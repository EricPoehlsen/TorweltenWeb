<?php 
include "_checklogin.php";

    // This page is used to add character traits

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
        $sql = "SELECT `charname`, `charid` FROM `characters` WHERE `charid` = ?";
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
        <script src="addtraits.js"></script>
</head>
<body onload="getTraits(<?php echo $c['charid']; ?>)">
    <div id="userbar"><?php include "_userbar.php"; ?></div>
    <h1>Eigenschaften für <?php echo $c['charname'];?> auswählen ...</h1>
    <p>Zum Einschränken der Liste, einfach einen Teil der Bezeichnung der gesuchten Eigenschaft ins Suchfeld eingeben.</p>
    <p>Bereits gewählte Eigenschaften können nicht erneut hinzugefügt werden. Die Prüfung erfolgt auf Ebene des Namens der Eigenschaft. Wenn man &quot;Schulden&quot; später in &quot;Schulden (Ausbildung)&quot; umbenennt, kann man noch einmal den Nachteil Schulden hinzufügen.</p>
    <p>Um weiterführende Informationen zu jeder Eigenschaft anzuzeigen, kann man den Namen anklicken, dann wird der Beschreibungstext eingeblendet.</p>  
    <p>Eigenschaften mit mehreren Rängen werden stets auf Rang 1 hinzugefügt. Um den Rang zu ändern oder eine Eigenschaft wieder zu entfernen, einfach die Eigenschaft in der Charakteransicht bearbeiten.</p>
    <label for="search">Suche:</label>
    <input id="search" onkeyup="getTraits(<?php echo $c['charid']; ?>)"/>
    <div id="traitlist">
    </div>
</body>
</html>
