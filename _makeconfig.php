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
            <p>Database connection successful ...</p>
            <p><a href="install.php">Continue ...</p>
            <?php
        } catch (Exception $e) {
            unlink("config.php");
            ?>
            <p>Database connection failed ...</p>
            <p><a href="install.php">Continue ...</p>
            <?php
        }
    } else {
        ?>
        <form method="POST">
        <h1>Enter Database Credentials</h1>
        DB_SERV: <input name="db_serv"/><br/>
        DB_NAME: <input name="db_name"/><br/>
        DB_USER: <input name="db_user"/><br/>
        DB_PASS: <input name="db_pass" type="password"/><br/>
        <input type="submit" value="Create Config"/>
        </form>
        <?php
    }

?>
