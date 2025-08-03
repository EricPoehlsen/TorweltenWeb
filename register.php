<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <form method="POST">
            Username: <input label="USER" name="user"/><br/>
            Password: <input label="PASS" name="pass" type="password"/><br/>
            Password: <input label="PCHK" name="passcheck" type="password"/><br/>
            E-Mail: <input label="MAIL" name="mail" type="email"/><br/>
            <input name="Submit" type="submit"/>
        </form>
        <?php
            # echo phpinfo();
            require "config.php";
            $db = new mysqli($db_serv, $db_user, $db_pass, $db_name);
            if ($db->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

        



        $error = "";
        if(array_key_exists("pass", $_POST)) {
            if ($_POST["pass"] != $_POST["passcheck"]) {
                $error = $error . "Password mismatch!";
            }

            $hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
            echo "$hash<br/>";
        }
        echo "<p>$error</p>";
        ?>

    </body>
</html>