<?php
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);
    $admin = $db->query("SELECT `username` FROM `users` WHERE `access` = 99");
    if ($admin->rowCount() > 0) {
        ?>
        <h1>Installation abgeschlossen ...</h1>
        <p>Es scheint, als wäre die Installation erfolgreich abgeschlossen.</p>
        <p>Die Datenbankverbindung wurde erfolgreich hergestellt. Und ein Besitzerkonto angelegt.</p>
        <p>Aus Sicherheitsgründen wurde das Installationsskript zu install.bak umbenannt.</p>
        <p><a href="index.php">Zur Seite ...</a></p>
        <?php
        // rename("install.php", "install.bak");
    }
?>