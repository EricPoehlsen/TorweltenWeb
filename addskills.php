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

    // user has edit rights?
    $edit = false;

    //get data
    if (isset($_GET["id"])) {
        // character data
        $id = intval($_GET["id"]);
        $sql = "SELECT * FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $c = $stmt->fetch();

        // has user editor access?
        $editors = explode(",", $c["editors"]);
        $owner = $c["userid"];
        if (in_array($_SESSION["userid"], $editors)) $edit = true;
        if ($_SESSION["userid"] == $owner) $edit = true;
    }

    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>Fertigkeiten hinzufügen</title>";
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    echo "<script src=\"addskills.js\"></script>";
    echo "</head>";
    $script = "";
    if ($edit) $script = " onload=\"getSkills({$c['charid']})\"";
    echo "<body$script>";
    echo "<div id=\"userbar\">";
    include "_userbar.php";
    echo "</div>";
    if ($edit) {
        echo "<label for=\"search\">Suche:</label>";
        echo "<input id=\"search\" onkeyup=\"getSkills({$c['charid']})\"/>";
        echo "<div id=\"skilllist\"></div>";

    } else {
        echo "<p>Kein Zugriff!</p>";
    }
    echo "</body>";
    echo "</html>";
?>