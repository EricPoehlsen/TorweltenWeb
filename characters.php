<?php 
include "_checklogin.php";

// This page shows all characters of a user

    // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>
    <h1>Charaktere</h1>
    <?php 
        //get characters from database
        $sql = "SELECT charid, charname, species, concept FROM characters WHERE userid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($_SESSION["userid"])]);
        $characters = $stmt->fetchAll();
        //display characters
        foreach ($characters as $c) {
            echo "<p><a href='character.php?id={$c['charid']}'>{$c['charname']}</a> - {$c['species']} - {$c['concept']}</p>";
        }
    ?>

    <p><a href="newcharacter.php">Neuen Charakter anlegen</a></p>


</body>
</html>