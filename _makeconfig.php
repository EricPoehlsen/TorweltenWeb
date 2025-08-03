<?php
    // Write the config file
    if(array_key_exists("db_pass", $_POST)) {
        $file = "<?php\n" .
                "\t//This file stores the login credentials to the database\n" .
                "\t" . '$db_serv = "' . $_POST["db_serv"] . '";' ."\n" . 
                "\t" . '$db_name = "' . $_POST["db_name"] . '";' ."\n" .
                "\t" . '$db_user = "' . $_POST["db_user"] . '";' ."\n" .
                "\t" . '$db_pass = "' . $_POST["db_pass"] . '";' ."\n" .
                '?>';
        file_put_contents("config.php",$file);
        $db_name = $_POST["db_name"];
        $db_serv = $_POST["db_serv"];
        $db_user = $_POST["db_user"];
        $db_pass = $_POST["db_pass"];
        $dsn = "mysql:dbname=$db_name;host=$db_serv";
        try {   
            $db = new PDO($dsn, $db_user, $db_pass);
            ?>
            <h1><?php echo $M["t_db_success"]; ?></h1>
            <p><a href="install.php"><?php echo $M["l_continue"]; ?></p>
            <?php
        } catch (Exception $e) {
            unlink("config.php");
            ?>
            <h1><?php echo $M["t_db_failed"]; ?></h1>
            <p><a href="install.php"><?php echo $M["l_continue"]; ?></p>
            <?php
        }
    } else {
        ?>
        <form method="POST">
        <h1><?php echo $M['h_enter_db_creds']; ?></h1>
        <?php echo $M['t_db_serv']; ?><input name="db_serv"/><br/>
        <?php echo $M['t_db_name']; ?><input name="db_name"/><br/>
        <?php echo $M['t_db_user']; ?><input name="db_user"/><br/>
        <?php echo $M['t_db_pass']; ?><input name="db_pass" type="password"/><br/>
        <input type="submit" value="<?php echo $M["b_create_config"]; ?>"/>
        </form>
        <?php
    }

?>
