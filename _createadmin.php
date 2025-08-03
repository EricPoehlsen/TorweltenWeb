<?php
    try {
        // connect to database
        include "config.php";
        $dsn = "mysql:dbname=$db_name;host=$db_serv";
        $db = new PDO($dsn, $db_user, $db_pass);
        
        //handle $_POST to create owner account in database
        if(array_key_exists("user", $_POST)) {
            $user = $_POST['user'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $mail = $_POST['mail'];
            $sql = "INSERT INTO users (username, passhash, mail, access) VALUES (?, ?, ?, 99)";
            $insert = $db->prepare($sql);
            $insert->execute([$user, $pass, $mail]);
        } 

        //display form only if owner does not yet exist. 
        $admin = $db->query("SELECT username FROM users WHERE access = 99");
        if ($admin->rowCount() == 0) {
            ?>
            <form method="POST">
            <h1>Create Owner User</h2>
            Username: <input name="user"/><br/>
            E-Mail: <input name="mail" type="email"/><br>
            Password: <input name="pass" type="password"/><br/>
            Password: <input name="pchk" type="password"/><br/>
            <input type="Submit" value="Create"/>
            </form>
            <?php
        } else {
            $owner = $admin->fetchAll()[0]["username"];
            ?>
            <h1>Owner user exists</h1>
            <p>The user <i><?php echo($owner); ?></i> is registered as owner of this site.
            <p><a href="install.php">Continue...</a></p>
            <?php
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        ?>
        <h1>something went wrong</h1>
        <p>Check your config and try again ...</p>
        <?php
    }
?>