<?php 
include "_checklogin.php";

// this code retrieves the skill list from the server

  // connect DB
include "config.php";
$dsn = "mysql:dbname=$db_name;host=$db_serv";
$db = new PDO($dsn, $db_user, $db_pass);

//get data
if (isset($_POST["charid"])) {
    $charid = $_POST["charid"];
    $public = $_POST["public"];
    if ($public == "true") {
        $sql = "UPDATE characters SET public=1 WHERE charid=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$charid]);
    } else {
        $sql = "UPDATE characters SET public=0 WHERE charid=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$charid]);
    }
}

