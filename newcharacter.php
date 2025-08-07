<?php 
    include "_checklogin.php";
    ini_set('display_errors', 1); 

    $charid = 0;
    // This page creates a new character

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
            $charid = $db->lastInsertId();
        }
    }

 ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="script.js"></script>
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>

    <?php 
    // show form only if character was not yet created
    if ($charid == 0) {
    ?>
    <form method="POST">
        <label for="charname">Name:</label><input name="charname" id="charname"/>
        <label for="species">Spezies:</label><input name="species" id="species"/>
        <label for="concept">Konzept:</label><input name="concept" id="concept"/>
        <input type="submit" value="Speichern" />
    </form>
    <?php
    // show link to the character just created.
    } else {
    ?>
    <p><a href="character.php?id=<?php echo $charid;?>">Zum Charakter</a><p>
    <?php
    } 
    ?>


</body>
</html>