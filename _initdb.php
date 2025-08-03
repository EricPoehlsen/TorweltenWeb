<h1><?php echo $M["h_db_init"]; ?></h1>
<?php
    try {
        include "config.php";
        $dsn = "mysql:dbname=$db_name;host=$db_serv";
        $db = new PDO($dsn, $db_user, $db_pass);
        $init = file_get_contents("init.sql");
        $qr = $db->exec($init);
        echo "<p>{$M["t_db_done"]}<p>";
        echo "<p><a href='install.php'>{$M["l_continue"]}</a></p>";
    } catch (Exception $e) {
        echo "<p><b>{$M["t_db_fail"]}</b>";
    }
?>