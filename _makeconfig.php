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
            <h1>Datenbankverbindung erfolgreich.</h1>
            <p><a href="install.php">Weiter ...</p>
            <?php
        } catch (Exception $e) {
            unlink("config.php");
            ?>
            <h1>Datenbankverbindung fehlgeschlagen ...</h1>
            <p><a href="install.php">Neu eingeben ...</p>
            <?php
        }
    } else {
        ?>
        <form method="POST">
        <h1>Datenbankzugang einrichten ...</h1>
        <p>Datenbankserver: <input name="db_serv"/><br/>
        <p>Datenbankname: <input name="db_name"/><br/>
        <p>Datenbankbenutzer: <input name="db_user"/><br/>
        <p>Datenbankpasswort: <input name="db_pass" type="password"/><br/>
        <input type="submit" value="Konfigurationsdatei erstellen"/>
        </form>
        <?php
    }

?>
