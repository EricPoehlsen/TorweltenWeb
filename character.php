<?php 
include "_checklogin.php";
ini_set('display_errors', 1); 

    // This page manages a single character

    // generate the attribute view
    function attribView($attr, $charid, $value) {
        $attr_upper = strtoupper($attr);
        echo "<label for=\"$attr\">$attr_upper</label>";
        echo "<button onclick=\"updateAttrib('$attr','dec','$charid')\"> - </button>";
        echo "<input id=\"$attr\" size=\"2\" value=\"$value\"/>";
        echo "<button onclick=\"updateAttrib('$attr','inc','$charid')\"> + </button>";
    }



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

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="script.js"></script>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>

    <form method="POST">
        <label for="charname">Name:</label><input name="charname" id="charname" value="<?php echo $c["charname"]; ?>"/>
        <label for="species">Spezies:</label><input name="species" id="species" value="<?php echo $c["species"]; ?>"/>
        <label for="concept">Konzept:</label><input name="concept" id="concept" value="<?php echo $c["concept"]; ?>"/>
    </form>
    <?php 
    //display the attribute views for the attributes
    $attribs = array("phy", "men", "soz", "nk", "fk", "lp", "ep", "mp");
    foreach ($attribs as $attr) {
        attribView($attr, $c["charid"], $c[$attr]);
    }
    
    ?>








</body>
</html>