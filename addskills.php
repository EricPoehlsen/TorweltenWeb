<?php 
include "_checklogin.php";
ini_set('display_errors', 1); 

    // This page is used to add skills to a character

      // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    //character data
    $c = [];
    $c["charname"] = "";
    $c["species"] = "";
    $c["concept"] = "";
    $c["charid"] = "0";
    
    //load character
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $sql = "SELECT * FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $c = $stmt->fetch();
    }

    $charid = $c["charid"];

    $sql = "SELECT * FROM skills ORDER BY id";
    $stmt = $db->query($sql);
    $skills = $stmt->fetchAll();



?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>
    <?php
    foreach ($skills as $skill) {
        echo "<p>{$skill['skill']}</p>";
    }
    ?>
  
</body>
</html>
