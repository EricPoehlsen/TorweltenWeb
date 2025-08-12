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
        $char = $stmt->execute([$id]);
        $data = $char->fetchAll();
        if (len($data) > 0) $c = $data;



        // all skills
        $sql = "SELECT * FROM traits ORDER BY id";
        $stmt = $db->query($sql);
        $traits = $stmt->fetchAll();
        

        $sql = "SELECT * FROM charskills WHERE charid = ?";
        $stmt = $db->prepare($sql);

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
    <label for="search">Suche:</label>
    <input id="search" />
    <div id="traitlistlist">
        <?php
            echo $c["charname"];
            foreach ($traits as $trait) {
                echo "<div class='attribcontainer'>";
                echo "<p>{$trait['title']}</p>";
                
                echo "</div>";
            }
        ?>



    </div>
</body>
</html>
