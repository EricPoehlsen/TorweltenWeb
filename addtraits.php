<?php 
include "_checklogin.php";

    // This page is used to add attributes  to a character

      // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    //character data
    $c = [];
    $c["charname"] = "";
    $c["charid"] = "0";

    $traits = [];
    //get data
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $sql = "SELECT charname, charid FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetchAll();
        if (count($data) > 0) $c = $data[0];
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="style.css">
        <script src="traits.js"></script>
</head>
<body onload="getTraits(<?php echo $c['charid']; ?>)">
    <div id="userbar"><?php include "_userbar.php"; ?></div>
    <h1>Eigenschaften für <?php echo $c['charname'];?> auswählen ...</h1>
    <label for="search">Suche:</label>
    <input id="search" onkeyup="getTraits(<?php echo $c['charid']; ?>)"/>
    <div id="traitlist">
    </div>
</body>
</html>
