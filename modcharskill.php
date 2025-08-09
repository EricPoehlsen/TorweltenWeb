<?php 
include "_checklogin.php";

// This code is used to modify skills of a character

// connect DB
include "config.php";
$dsn = "mysql:dbname=$db_name;host=$db_serv";
$db = new PDO($dsn, $db_user, $db_pass);

// do we have a POST access to this resource?
if (isset($_POST["charid"])) {
    $lvl = 0;
    $stype = "A";
    $charid = intval($_POST["charid"]);
    $skillid = intval($_POST["skillid"]);

    // check if character already has skill
    $sql = "SELECT lvl, stype FROM charskills WHERE charid = ? AND skillid = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$charid, $skillid]); 
    if ($stmt->rowCount() > 0) { // character already has the skill
        $result = $stmt->fetch();
        $lvl = $result["lvl"];
        $stype = $result["stype"];
    } else { // this is a new skill
        $sql = "SELECT stype FROM skills WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$skillid]);
        if ($stmt->rowCount() > 0) { // the skill exists
            $result = $stmt->fetch();
            $stype = $result["stype"];
            $lvl = 1;
            $sql = "INSERT INTO charskills (charid, skillid, lvl, stype) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$charid, $skillid, $lvl, $stype]);
        } 
    }
    echo $lvl;
}

