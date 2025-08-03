<?php
    $login = 0;
    session_name("Torwelten");
    session_start();

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
    
    if (array_key_exists("logout", $_GET)) { //handle logout via $_GET parameter
        $token = $_COOKIE["TorweltenLogin"];
        $valid_token = preg_match("/^[0-9a-f]{128}$/", $token);
        if ($valid_token == true) {
            echo "trying to delete token";
            $sql = "DELETE FROM logins WHERE token = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$token]);
        }
        $login = -2;
        $_SESSION = []; 
    } 
    // Let's build the site
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>
<?php
    switch ($login) { // Header based on Login result
        case -2:
            echo "<h1>Logged out</h1>";
            break;
        case -1:
            echo "<h1>Login failed ...</h1>";
            break;
        case 0:
            echo "<h1>Please login ...</h1>";
            break;
        case 1:
            echo "<h1>Login successful</h1>";
            break;
    }
    if ($login == -1 OR $login == 0) { // show the login form?
        ?>
        <form method="POST">
            <input placeholder="username" name="user"/>
            <input placeholder="password" name="pass" type="password"/>
            <input value="login" type="submit"/>
        </form>
        <?php
    }
?>
<a href="index.php">Continue ...</a>
</body>
</html>
