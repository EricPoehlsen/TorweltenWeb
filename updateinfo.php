<?php 
include "_checklogin.php";

    // This script is called by XHR from character.js and updates character information

    // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    //get data
    if (isset($_POST["charid"])) {
        // has user editor access? 
        // missing access fails silently because the user should not call this script if not authorized
        // this is a double check on the server side of things ...
        $edit = false;
        $sql = "SELECT userid, editors, charid FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['charid']]);
        $c = $stmt->fetch();
        $editors = explode(",", $c["editors"]);
        $owner = $c["userid"];
        if (in_array($_SESSION["userid"], $editors)) $edit = true;
        if ($_SESSION["userid"] == $owner) $edit = true;

        if ($edit) {
            $info = $_POST['info'];
            $content = htmlspecialchars($_POST['content']);
            $charid = $c['charid'];

            if (in_array($info, ["charname", "species", "concept"])) {
                $sql = "UPDATE characters SET $info = ? WHERE charid = $charid";
                $stmt = $db->prepare($sql);
                $stmt->execute([$content]);
            }







            echo "... updating ...";
        }
    }
