<?php 
include "_checklogin.php";

    // This script is called by XHR from addtraits.js and adds a character trait

    // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    //character data
    $c = [];
    $c["charname"] = "";
    $c["charid"] = "0";

    //get data
    if (isset($_POST["charid"])) {
        $charid = intval($_POST["charid"]);
        
        // has user editor access? 
        // missing access fails silently because the user should not have access to the page
        // this is a double check on the server side of things ...
        $edit = false;
        $sql = "SELECT `userid`, `editors` FROM `characters` WHERE `charid` = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$charid]);
        $c = $stmt->fetch();
        $editors = explode(",", $c["editors"]);
        $owner = $c["userid"];
        if (in_array($_SESSION["userid"], $editors)) $edit = true;
        if ($_SESSION["userid"] == $owner) $edit = true;

        if ($edit) {

            // get trait
            $traitid = intval($_POST["traitid"]);
            $sql = "SELECT * FROM `traits` WHERE `id` = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$traitid]);
            $data = $stmt->fetchAll();

            // insert trait into char traits ...
            $trait = $data[0];
            $sql = "INSERT INTO `chartraits` (`charid`, `title`, `tdesc`, `maxrank`, `xpcost`, `traittype`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $trait["title"], $trait["tdesc"], $trait["maxrank"], $trait["xpcost"], $trait["traittype"]]);
            
            // log xp
            $userid = $_SESSION["userid"];
            $reason = "Eigenschaft {$trait['title']} hinzugefügt";
            $sql = "INSERT INTO `xplog` (`charid`, `userid`, `xp`, `reason`) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $userid, $trait["xpcost"], $reason]);
        }
        echo $edit;
    }
