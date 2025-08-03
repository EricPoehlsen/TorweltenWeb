<h1>Preparing Database</h1>
<?php
    try {
        include "config.php";
        $dsn = "mysql:dbname=$db_name;host=$db_serv";
        $db = new PDO($dsn, $db_user, $db_pass);
        $init = file_get_contents("init.sql");
        $qr = $db->exec($init);
        echo "<p>Database ready ... <p>";
        echo "<p><a href='install.php'>Continue ...</a></p>";
    } catch (Exception $e) {
        echo "<p><b>Something went wrong, check your config.php</b>";
    }
?>