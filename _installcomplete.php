<?php
    try {
        include "config.php";
        $dsn = "mysql:dbname=$db_name;host=$db_serv";
        $db = new PDO($dsn, $db_user, $db_pass);
        $admin = $db->query("SELECT username FROM users WHERE access = 99");
        if ($admin->rowCount() > 0) {
            ?>
            <h1>Installation complete ...</h1>
            <p>It appears your install is complete the database exists and an owner user was created.</p>
            <p>To reinstall the site remove the <i>config.php</i> file and call the install script again.</p>
            <p>For security reasons the install script was renamed <i>install.bak</i>.
            <p><a href="index.php">Go to site...</a></p>
            <?php
            rename("install.php", "install.bak");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        ?>
        <h1>something went wrong</h1>
        <p>Check your config and try again ...</p>
        <?php
    }
?>