<?php 
include "_checklogin.php";
ini_set('display_errors', 1); 

    // This page manages a single character

    // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    // handle POST
    if (isset($_POST["charname"])) {
        //new character
        if (!isset($_SESSION["charid"])){
            $sql = "INSERT INTO characters (userid, charname, species, concept) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([intval($_SESSION["userid"]), $_POST["charname"], $_POST["species"], $_POST["concept"]]);
        }
    }

    //load character
    if (isset($_GET["id"]) && is_int($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
    }



?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>

    <form method="POST">
        <label for="charname">Name:</label><input name="charname" id="charname" />
        <label for="species">Spezies:</label><input name="species" id="species" />
        <label for="concept">Konzept:</label><input name="concept" id="concept" />
        <input type="submit" value="Speichern" />
    </form>



</body>
</html>