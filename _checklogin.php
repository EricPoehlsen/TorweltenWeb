<?php
    ini_set('display_errors', 1); 
    session_name("Torwelten");
    session_start();
    if (isset($_SESSION["userid"])){
        //already logged in
    } else if (isset($_COOKIE["TorweltenLogin"])) {
        //check format of token from cookie
        $token = $_COOKIE["TorweltenLogin"];
        $valid_token = preg_match("/^[0-9a-f]{128}$/", $token);
        if ($valid_token == true) {
            //connect to database
            include "config.php";
            $dsn = "mysql:dbname=$db_name;host=$db_serv";
            $db = new PDO($dsn, $db_user, $db_pass);

            //try to find userid based on token
            $sql = "SELECT `userid` FROM `logins` WHERE `token` = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$token]);
            if ($stmt->rowCount()>0) {
                $_SESSION["userid"] = $stmt->fetch()["userid"];
            }

            // get username and access based on userid
            if (isset($_SESSION["userid"])) {
                $sql = ("SELECT `username`, `access` FROM `users` WHERE `userid` = ?");
                $stmt = $db->prepare($sql);
                $stmt->execute([$_SESSION["userid"]]);
                $result = $stmt->fetch();
                $_SESSION["username"] = $result["username"];
                $_SESSION["access"] = $result["username"];
            }


        } else {
            echo "WARNING: INVALID COOKIE!";
        }
    }
?>
