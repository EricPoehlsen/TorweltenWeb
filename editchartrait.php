<?php 
include "_checklogin.php";

    // This page is used to modify a character trait

    // connect DB
    include "config.php";
    $dsn = "mysql:dbname=$db_name;host=$db_serv";
    $db = new PDO($dsn, $db_user, $db_pass);

    //ACL check
    $edit = false;
    $charid = 0;
    if (isset($_GET['charid'])) $charid = $_GET['charid'];
    if (isset($_POST['charid'])) $charid = $_POST['charid'];
    $sql = "SELECT userid, editors FROM characters WHERE charid = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$charid]);
    $c = $stmt->fetch();
    $editors = explode(",", $c["editors"]);
    $owner = $c["userid"];
    if (in_array($_SESSION["userid"], $editors)) $edit = true;
    if ($_SESSION["userid"] == $owner) $edit = true;
    if (!$edit) die;

    $trait = [];
    // handle the $_GET to load the current data
    if (isset($_GET["traitid"])) {
        $charid = intval($_GET["charid"]);
        $traitid = intval($_GET["traitid"]);

        $sql = "SELECT * FROM chartraits WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$traitid]);
        $result = $stmt->fetchAll();
        $trait = $result[0];
    }

    // handle the form input by processing the POST
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $title = htmlspecialchars($_POST['title']);
        $tdesc = htmlspecialchars($_POST['desc']);
        $newrank = intval($_POST['rank']);

        $sql = "SELECT currank, xpcost FROM chartraits WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$traitid]);
        $result = $stmt->fetchAll();
        $currank = $result[0]['currank'];
        $xpcost = $result[0]['xpcost'];

        //update trait
        if (isset($_POST["update"])) {
            $sql = "UPDATE chartraits SET title = ?, tdesc = ?, currank = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$title, $tdesc, $newrank, $id]);

            // log action
            $xpcost = $newrank * $xpcost - $currank * $xpcost;
            $reason = "Eigenschaft $title auf Rang $newrank geändert.";
            $sql = "INSERT INTO xplog (userid, charid, reason, xp) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['userid'], $charid, $reason, $xpcost]);
        }

        //delete trait
        if (isset($_POST["delete"])) {
            $sql = "DELETE FROM chartraits WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);

            // log action
            $xpcost = 0 - $currank * $xpcost;
            $reason = "Eigenschaft $title entfernt.";
            $sql = "INSERT INTO xplog (userid, charid, reason, xp) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['userid'], $charid, $reason, $xpcost]);
        }

        // go back to character
        header("Location:character.php?id=$charid");
        exit();
    }



?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="editchartrait.js"></script>

        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>

    <form method="POST">
    <div class="container">
        <div class="line">
        <label for="title">Bezeichnung:</label><input class="traitname" name="title" id="title" value="<?php echo $trait["title"]; ?>"/>
        <?php 
        if ($trait["maxrank"] > 1) { 
            echo "<label for=\"rank\">Rang:</label>";
            echo "<button type=\"button\" onClick=\"changeRank('down')\">◀︎</button>";
            echo "<input id=\"rank\" name=\"rank\" type=\"text\" size=\"3\" value=\"{$trait['currank']}\"/>";
            echo "<button type=\"button\" onClick=\"changeRank('up',{$trait['maxrank']})\">▶︎</button>";
        } else {
            echo "<input name=\"rank\" type=\"hidden\" value=\"{$trait['currank']}\"/>";
        }
        ?>
        </div>
        <div>
        <label for="desc">Beschreibung:</label><br/><textarea name="desc" id ="desc"><?php echo $trait['tdesc']; ?></textarea>
        </div>
        <div>
        <input type="submit" name="update" value="Speichern"/>
        <input type="submit" name="cancel" value="Abbrechen"/>
        <input type="submit" name="delete" value="Entfernen"/>
        <input type="hidden" name="id" value="<?php echo $trait['id'];?>"/>
        <input type="hidden" name="charid" value="<?php echo $charid;?>"/>

        </div>
    </div>
    </form>
</body>
</html>
