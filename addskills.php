<?php 
include "_checklogin.php";

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

    $skills = [];
    $charskills = [];

    //get data
    if (isset($_GET["id"])) {
        // character data
        $id = intval($_GET["id"]);
        $sql = "SELECT * FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $c = $stmt->fetch();
    
        // all skills
        $sql = "SELECT * FROM skills ORDER BY id";
        $stmt = $db->query($sql);
        $skills = $stmt->fetchAll();
        

        $sql = "SELECT * FROM charskills WHERE charid = ?";
        $stmt = $db->prepare($sql);

    }


?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="style.css">
        <script src="skills.js"></script>
</head>
<body onload="getSkills(<?php echo $c['charid']; ?>)">
    <div id="userbar"><?php include "_userbar.php"; ?></div>
    <label for="search">Suche:</label>
    <input id="search" onkeyup="getSkills(<?php echo $c['charid']; ?>)" />
    <div id="skilllist"></div>
</body>
</html>
