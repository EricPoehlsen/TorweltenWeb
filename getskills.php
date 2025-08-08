<?php 
include "_checklogin.php";
ini_set('display_errors', 1); 

// This page is used to add skills to a character

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

    
    $skills = [];
    // all skills
    if ($_POST["input"] == "") {
      $sql = "SELECT * FROM skills ORDER BY id";
      $stmt = $db->query($sql);
      $skills = $stmt->fetchAll();
    } else {
      $input = "%{$_POST["input"]}%";
      $sql = "SELECT * FROM skills WHERE skill LIKE ? ORDER BY id";
      $stmt = $db->prepare($sql);
      $stmt->execute([$input]);
      $skills = $stmt->fetchAll();
    }
    
    $sql = "SELECT * FROM charskills WHERE charid = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$sql]);
    $charskills = $stmt->fetchAll();

    print_r($charskills);

    $result = [];
    foreach ($skills as $skill) {
      $lvl = 0;
      foreach ($charskills as $charskill) {
        if ($charskill["skillid"] == $skill["id"]) {
          $lvl = $charskill["lvl"];
        }
      }
      $id = $skill["id"];
      $result[$id] = array(
        "skill" => $skill["skill"],
        "lvl" => $lvl,
        "stype" => $skill["stype"],
        "base" => $skill["base"]
      );
    }

    $result = json_encode($result);

    echo $result;
}

