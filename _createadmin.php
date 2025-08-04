<?php

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
        <h1>Besitzerkonto anlegen</h1>
        <p>Benutzername: <input name="user"/></p>
        <p>E-Mail: <input name="mail" type="email"/></p>
        <p>Passwort: <input name="pass" type="password"/></p>
        <p>Passwort: <input name="pchk" type="password"/></p>
        <input type="Submit" value="Registrieren"/>
        </form>
        <?php
    } else {
        $owner = $admin->fetchAll()[0]["username"];
        ?>
        <h1>Besitzerkonto angelegt</h1>
        <p>Der Benutzer <i><?php echo $owner; ?> wurde als Besitzerkonto im System registriert.</p>
        <p><a href="install.php">Weiter ...</a></p>
        <?php
    }

?>