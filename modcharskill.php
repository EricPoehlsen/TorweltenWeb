<?php 
include "_checklogin.php";

// This code is used to modify skills of a character

// connect DB
include "config.php";
$dsn = "mysql:dbname=$db_name;host=$db_serv";
$db = new PDO($dsn, $db_user, $db_pass);

// do we have a POST access to this resource?
if (isset($_POST["charid"])) {
    $userid = $_SESSION["userid"];
    $lvl = 0;
    $stype = "A";
    $charid = intval($_POST["charid"]);
    $skillid = intval($_POST["skillid"]);

    // get the skill name
    $sql = "SELECT skill FROM skills WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$skillid]);
    $skillname = $stmt->fetch()["skill"];   

    // check if character already has skill
    $sql = "SELECT lvl, stype FROM charskills WHERE charid = ? AND skillid = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$charid, $skillid]); 
    if ($stmt->rowCount() > 0) { // character already has the skill
        $result = $stmt->fetch();
        $lvl = $result["lvl"];
        $stype = $result["stype"];
        
        // standard action = inc(rease), valid are also dec(rease) and del(ete)
        $action = "inc";
        if (isset($_POST["action"]) && in_array($_POST["action"], ["inc", "dec", "del"])) $action = $_POST["action"];
        
        // increase skill level
        if ($action == "inc" && $lvl < 4) {
            $lvl += 1;
            $cost = 2;
            if ($stype != "A") $cost = 1;
            $xpcost = $lvl * $cost;
            
            // update skill
            $sql = "UPDATE charskills SET lvl = ? WHERE charid = ? AND skillid = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$lvl, $charid, $skillid]);

            // log action
            $reason = "Fertigkeit $skillname auf $lvl gesteigert";

            $sql = "INSERT INTO xplog (charid, userid, xp, reason) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $userid, $xpcost, $reason]);
        }



    } else { // this is a new skill
        $sql = "SELECT stype FROM skills WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$skillid]);
        if ($stmt->rowCount() > 0) { // the skill exists
            $result = $stmt->fetch();
            $stype = $result["stype"];
            $lvl = 1;

            // add skill
            $sql = "INSERT INTO charskills (charid, skillid, lvl, stype) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $skillid, $lvl, $stype]);

            //log action
            $cost = 2;
            if ($stype != "A") $cost = 1;
            $xpcost = $lvl * $cost;
            $reason = "Fertigkeit $skillname hinzugefügt";
            $sql = "INSERT INTO xplog (charid, userid, xp, reason) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $userid, $xpcost, $reason]);

        } 
    }
    echo $lvl;
}

