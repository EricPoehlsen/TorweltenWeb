<?php 
include "_checklogin.php";
ini_set('display_errors', 1); 

    // This page manages a single character

    // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    //character data
    $c = [];
    $c["charname"] = "";
    $c["species"] = "";
    $c["concept"] = "";
    

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
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $sql = "SELECT * FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $c = $stmt->fetch();
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
        <label for="charname">Name:</label><input name="charname" id="charname" value="<?php echo $c["charname"]; ?>"/>
        <label for="species">Spezies:</label><input name="species" id="species" value="<?php echo $c["species"]; ?>"/>
        <label for="concept">Konzept:</label><input name="concept" id="concept" value="<?php echo $c["concept"]; ?>"/>
        <input type="submit" value="Speichern" />
    </form>



</body>
</html>