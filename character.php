<?php 
include "_checklogin.php";

    // This page manages a single character

    // generate the attribute view
    function attribView($attr, $charid, $value, $edit) {
        $attr_upper = strtoupper($attr);
        echo "<div class=\"attr\">";
        echo "<div>";
        echo "<label class=\"attr\" for=\"$attr\">$attr_upper</label>";
        echo "</div>";
        echo "<div class=\"line\">";
        if ($edit) echo "<button onclick=\"updateAttrib('$attr','dec','$charid')\"> - </button>";
        echo "<input class=\"attribfield\" id=\"$attr\" size=\"2\" value=\"$value\"/>";
        if ($edit) echo "<button onclick=\"updateAttrib('$attr','inc','$charid')\"> + </button>";
        echo "</div>";
        echo "</div>";
    }

    $edit = false;

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
        // basic data
        $id = intval($_GET["id"]);
        $sql = "SELECT * FROM characters WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $c = $stmt->fetch();
        
        //skills
        $sql = "SELECT 
                    skills.id AS id,
                    charskills.lvl AS lvl, 
                    skills.stype AS stype, 
                    skills.skill AS skill
                FROM charskills
                INNER JOIN skills
                ON skills.id = charskills.skillid
                WHERE charskills.charid = ?
                ORDER BY skills.id";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $skills = $stmt->fetchAll();

        //traits
        $sql = "SELECT * FROM chartraits WHERE charid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $traits = $stmt->fetchAll();

        // editor access
        $editors = explode(",", $c["editors"]);
        $owner = $c["userid"];
        if (in_array($_SESSION["userid"], $editors)) $edit = true;
        if ($_SESSION["userid"] == $owner) $edit = true;

    }


    $charid = $c["charid"];

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="character.js"></script>

        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>

    <form method="POST">
        <label for="charname">Name:</label><input name="charname" id="charname" value="<?php echo $c["charname"]; ?>"/>
        <label for="species">Spezies:</label><input name="species" id="species" value="<?php echo $c["species"]; ?>"/>
        <label for="concept">Konzept:</label><input name="concept" id="concept" value="<?php echo $c["concept"]; ?>"/>
    </form>
    <div class="attributes">
    <?php 
    //display the attribute views for the attributes
    $attribs = array("phy", "men", "soz", "nk", "fk", "lp", "ep", "mp");
    foreach ($attribs as $attr) {
        attribView($attr, $c["charid"], $c[$attr], $edit);
    }

    ?>
    </div>
    <div class="skillbox">
    <?php 
    foreach ($skills as $skill) {
        echo "<div class='skill'>{$skill['skill']} - {$skill['lvl']}</div>";
    }    
    ?>
    </div>
    <a href="addskills.php?id=<?php echo $c["charid"]; ?>">Fertigkeiten ändern</a>

    <div id="traitbox">
    <?php 
    foreach ($traits as $trait) {
        echo "<div class=\"container\">";
        echo "<div id=\"trait.header.{$trait['id']}\" class=\"line\">";
        echo "<div id=\"trait.title.{$trait['id']}\">{$trait['title']}</div>";
        $rank = "";
        if ($trait["maxrank"] > 1) $rank = "<div id=\"trait.rank.{$trait['id']}\">[{$trait['currank']}]</div>";
        echo $rank;
        echo "<a href=\"editchartrait.php?charid={$c['charid']}&traitid={$trait['id']}\" class=\"traitedit\">🖋︎</a>";
        echo "</div>";
        echo "<div id=\"trait.desc.{$trait['id']}\">{$trait['tdesc']}</div>";
        echo "</div>";
    }    
    ?>
    </div>

    <a href="addtraits.php?id=<?php echo $c["charid"]; ?>">Eigenschaften hinzufügen</a>
    <p><label for="public">öffentlich</label><input type="checkbox" onchange="setPublic(<?php echo $c['charid'];?>)" id="public" <?php if ($c['public'] == 1) echo "checked";?>/></p>
</body>
</html>
