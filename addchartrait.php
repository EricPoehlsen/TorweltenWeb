<?php 
include "_checklogin.php";

    // This script is called by XHR from traits.js and adds a character trait

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
        $traitid = intval($_POST["traitid"]);
        $sql = "SELECT * FROM traits WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$traitid]);
        $data = $stmt->fetchAll();

        // insert trait into char traits ...
        if (count($data) > 0) {
            $trait = $data[0];
            $sql = "INSERT INTO chartraits (charid, title, tdesc, maxrank, xpcost, traittype) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $trait["title"], $trait["tdesc"], $trait["maxrank"], $trait["xpcost"], $trait["traittype"]]);
            
            // log xp
            $userid = $_SESSION["userid"];
            $reason = "Eigenschaft {$trait['title']} hinzugefügt";
            $sql = "INSERT INTO xplog (charid, userid, xp, reason) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $userid, $trait["xpcost"], $reason]);

            echo "1";
        } else {
            echo "0";
        }
    }
