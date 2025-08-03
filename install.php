<?php ini_set('display_errors', 1); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Install</title>
    </head>
    <body>
        <?php
            // Checking at which step of the install we are right now
            $install_step = 0;
            if (file_exists("config.php") == true) { // a config file exists 
                include "config.php";
                try {
                    $dsn = "mysql:dbname=$db_name;host=$db_serv";
                    $db = new PDO($dsn, $db_user, $db_pass);
                    $install_step = 1; // connected successfully to database
                    $tables = $db->query("SHOW TABLES LIKE 'users'");
                    if ($tables->rowCount() == 1) { // the users table exists
                        $install_step = 2;
                        $admin = $db->query("SELECT username FROM users WHERE access = 99"); //admin user exists
                        if ($admin->rowCount()>0) $install_step = 3;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                    $install_step = 0;
                }
            }
            
            //Select appropriate install step ...
            switch ($install_step) {
                case 0:
                    include "_makeconfig.php";
                    break;
                case 1:
                    include "_initdb.php";
                    break;
                case 2:
                    include "_createadmin.php";
                    break;
                case 3:
                    include "_installcomplete.php";
                    break;
            }
        ?>
    </body>
</html>