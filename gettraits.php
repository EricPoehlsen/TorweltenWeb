<?php 
include "_checklogin.php";

// this code retrieves the skill list from the server

  // connect DB
include "config.php";
$dsn = "mysql:dbname=$db_name;host=$db_serv";
$db = new PDO($dsn, $db_user, $db_pass);

//get data
if (isset($_POST["charid"])) {
    // character data
    $id = intval($_POST["charid"]);
    $sql = "SELECT * FROM characters WHERE charid = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $c = $stmt->fetch();

    
    $traits = [];
    // all traits
    if ($_POST["input"] == "") {
        $sql = "SELECT * FROM traits ORDER BY id";
        $stmt = $db->query($sql);
        $traits = $stmt->fetchAll();
    } else { // filtered by search
        $input = "%{$_POST["input"]}%";
        $sql = "SELECT * FROM traits WHERE title LIKE ? ORDER BY id";
        $stmt = $db->prepare($sql);
        $stmt->execute([$input]);
        $traits = $stmt->fetchAll();
    }

   
    // get character skills
    $sql = "SELECT * FROM chartraits WHERE charid = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST["charid"]]);
    $chartraits = $stmt->fetchAll();

    //build the list
    $result = [];
    foreach ($traits as $trait) {
        $hastrait = false;
        foreach ($chartraits as $chartrait) { // character has trait ...
        if ($chartrait["title"] == $trait["title"]) {
            $hastrait = true;
        }
        }
        $id = $trait["id"];
        $result[$id] = array(
        "title" => $trait["title"],
        "hastrait" => $hastrait,
        "desc" => $trait["tdesc"],
        "maxrank" => $trait["maxrank"],
        "xpcost" => $trait["xpcost"]
        );
    }

    $result = json_encode($result);
    echo $result;
}

