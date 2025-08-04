<h1>Datenbank wird initialisiert ...</h1>
<?php
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);
    $init = file_get_contents("init.sql");
    $qr = $db->exec($init);
    echo "<p>Datenbankinitialisierung abgeschlossen,<p>";
    echo "<p><a href='install.php'>Weiter...</a></p>";
?>