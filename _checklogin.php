<?php
    session_name("Torwelten");
    session_start();
    if (isset($_SESSION["userid"])){
        //already logged in
    } else if (isset($_COOKIE["TorweltenLogin"])) {
        $token = $_COOKIE["TorweltenLogin"];
        $valid_token = preg_match("/^[0-9a-f]{128}$/", $token);
        if ($valid_token == true) {
            include "config.php";
            $dsn = "mysql:dbname=$db_name;host=$db_serv";
            $db = new PDO($dsn, $db_user, $db_pass);

            $sql = "SELECT userid FROM logins WHERE token = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$token]);
            if ($stmt->rowCount()>0) {
                $userid = $stmt->fetch()["userid"];
                $_SESSION["userid"] = $userid;
            }
        } else {
            echo "WARNING: INVALID COOKIE!";
        }
    }
?>
