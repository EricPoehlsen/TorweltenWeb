<?php 
include "_checklogin.php";

// This page shows all characters of a user

    // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    //get characters from database
    $sql = "SELECT `charid`, `charname`, `species`, `concept`, `userid`, `editors` FROM `characters` WHERE `userid` = ? OR `public` = 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([intval($_SESSION["userid"])]);
    $characters = $stmt->fetchAll();

    //get users from database
    $users = []; 
    $sql = "SELECT `userid`, `username` FROM `users`";
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll();
    foreach ($result as $user) {
        $users[$user['userid']] = $user['username'];
    }

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
        //display characters
        foreach ($characters as $c) {
            echo "<div id=\"char.{$c['charid']}.{$c['userid']}\" class=\"container\" onclick=\"window.location.href='character.php?id={$c['charid']}'\">";
            echo "<div>";
            echo "<a href='character.php?id={$c['charid']}' class=\"charname\">{$c['charname']}</a> - {$c['species']} - {$c['concept']}";
            echo "</div>";
            echo "<div>";
            echo "<i>Spieler: {$users[$c['userid']]}</i>";
            echo "</div>";
            echo "</div>";
        }
    ?>

    <p><a href="newcharacter.php">Neuen Charakter anlegen</a></p>


</body>
</html>