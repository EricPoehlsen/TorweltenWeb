<?php
    $login = 0;
    try {
        global $login;
        // connect to database
        include "config.php";
        $dsn = "mysql:dbname=$db_name;host=$db_serv";
        $db = new PDO($dsn, $db_user, $db_pass);
        
        //handle $_POST to check login credentials
        if(array_key_exists("user", $_POST)) {
            $user = $_POST["user"];
            $pass = $_POST["pass"];
            $sql = "SELECT passhash, userid FROM users WHERE username = ?";
            $userdata = $db->prepare($sql);
            $userdata->execute([$user]);
            if ($userdata->rowCount() == 1) {
                $userdata = $userdata->fetchAll();
                $stored_hash = $userdata[0]["passhash"];
                $passcheck = password_verify($pass, $stored_hash);
                // Login okay - create token and cookie
                if ($passcheck == true) {
                    //generate token
                    $login = 1;
                    $token = hash("sha512",strval(time()).random_bytes(256).$stored_hash);
                    $expire = new DateTime()->setTimestamp(time() + 3600);
                    $expires = $expire->format("Y-m-d H:i:s"); 
                    $userid = $userdata[0]["userid"];
                    $sql = "INSERT INTO logins (userid, token, expires) VALUES ('$userid', '$token', '$expires')";
                    $db->exec($sql);
                    //Send cookie
                    setcookie("TorweltenLogin", $token, $expire->getTimestamp());
                } else {
                    $login = -1;
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        ?>
        <h1>something went wrong</h1>
        <p>Check your config and try again ...</p>
        <?php
    }

    if ($login == 1) {
        ?>
        <html>
            <head>
                <title>Login</title>
            </head>
            <body>
                <h1>Login successful</h1>
                <a href="index.php">Continue ...</a>
            </body>
        </html>
        <?php
    } else {
        ?>
        <html>
            <head>
                <title>Login</title>
            </head>
            <body>
                <?php if ($login == 0) echo "<h1>Please Login</h1>";
                      if ($login == -1) echo "<h1>Login Failed</h1>"; 
                ?>
                <form method="POST">
                    <input placeholder="username" name="user"/>
                    <input placeholder="password" name="pass" type="password"/>
                    <input value="login" type="submit"/>
                </form>
                <a href="index.php">Continue ...</a>
            </body>
        </html>
        <?php
    }
?>
