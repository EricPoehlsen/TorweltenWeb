<?php
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);
    $admin = $db->query("SELECT username FROM users WHERE access = 99");
    if ($admin->rowCount() > 0) {
        ?>
        <h1><?php echo $M["h_install_done"]; ?></h1>
        <p><?php echo $M["t_install_done"]; ?></p>
        <p><a href="index.php"><?php echo $M["l_to_site"]; ?></a></p>
        <?php
        rename("install.php", "install.bak");
    }
?>