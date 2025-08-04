<?php

    session_name("Torwelten");
    session_start();

    // connect to database
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);
    $error = "";
    $user_created = false;
    
    //handle $_POST to create user account in database
    if(array_key_exists("user", $_POST)) {
        
        if ($_POST["pass"] == $_POST["pchk"]) { // passwords match

            //check if username already exists
            $sql = "SELECT username FROM users WHERE username = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST["user"]]);
            if ($stmt->rowCount() == 0) { // username is unique, create user
                $user = $_POST['user'];
                $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                $mail = $_POST['mail'];
                $sql = "INSERT INTO users (username, passhash, mail, access) VALUES (?, ?, ?, 1)";
                $insert = $db->prepare($sql);
                $insert->execute([$user, $pass, $mail]);
                $user_created = true;
            } else {
                $error = "Ein Benutzerkonto mit diesem Namen existiert bereits.";
            }
        } else {
            $error = "Passwörter stimmen nicht überein!";
        }
    } 

    //display form only if the user was not yet created. 
    if ($user_created == false) {
        ?>
        <form method="POST">
        <h1>Benutzerkonto anlegen</h1>
        <p>Benutzername: <input name="user"/></p>
        <p>E-Mail: <input name="mail" type="email"/></p>
        <p>Passwort: <input name="pass" type="password"/></p>
        <p>Passwort: <input name="pchk" type="password"/></p>
        <input type="Submit" value="Registrieren"/>
        <p><span style="color:#f00"><?php echo $error;?></span></p>
        </form>
        <?php
    } else {
        ?>
        <h1>Benutzerkonto angelegt</h1>
        <p>Der Benutzer <i><?php echo $_POST["user"]; ?></i> wurde im System registriert.</p>
        <p><a href="index.php">Weiter ...</a></p>
        <?php
    }

?>