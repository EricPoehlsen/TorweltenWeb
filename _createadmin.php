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
        <h1><?php echo $M["h_register_owner"]; ?></h1>
        <?php echo $M["t_username"]; ?><input name="user"/><br/>
        <?php echo $M["t_mail"]; ?><input name="mail" type="email"/><br>
        <?php echo $M["t_password"]; ?><input name="pass" type="password"/><br/>
        <?php echo $M["t_password"]; ?><input name="pchk" type="password"/><br/>
        <input type="Submit" value="<?php echo $M["b_register"]; ?>"/>
        </form>
        <?php
    } else {
        $owner = $admin->fetchAll()[0]["username"];
        ?>
        <h1><?php echo $M["h_owner_exists"]; ?></h1>
        <p><?php echo str_replace("OWNER", $owner, $M["t_ownerinfo"]); ?></p>
        <p><a href="install.php"><?php echo $M["l_continue"]; ?></a></p>
        <?php
    }

?>