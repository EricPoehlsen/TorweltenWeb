<?php 
include "_checklogin.php";
$attr = $_POST["attr"]; //valid values see $valid_attribs below
$charid = intval($_POST["charid"]); //needs to be integer
$action = $_POST["action"]; //inc(rease), dec(rease) or set

$valid_attribs = ["phy", "men", "soz", "nk", "fk", "lp", "ep", "mp"];
if (!in_array($attr, $valid_attribs)) {
    echo "ERROR: Invalid attribute";
    die;
}

//connect database
include "config.php";
$dsn = "mysql:dbname=$db_name;host=$db_serv";
$db = new PDO($dsn, $db_user, $db_pass);

//get current value of attribute from the databas
$sql = "SELECT $attr FROM characters WHERE charid = $charid";
$stmt = $db->query($sql);
if ($stmt->rowCount() == 0) {
    echo "ERROR: Invalid character id";
    die;
}
$cur_value = $stmt->fetch()[$attr];
$new_value = 0;

// increase attribute by 1
if ($action == "inc") {
    
    //update the attribute
    $new_value = $cur_value + 1;
    $sql = "UPDATE characters SET $attr = $new_value WHERE charid = $charid";
    $db->exec($sql);

    //calculate and log xp costs
    $xp_cost = $new_value * 2;
    $userid = $_SESSION["userid"];
    $attrname = strtoupper($attr);
    $reason = "Attribut $attrname auf $new_value gesteigert.";
    $sql = "INSERT INTO xplog (charid, userid, xp, reason) VALUES ($charid, $userid, $xp_cost, '$reason')";
    $db->exec($sql);
}

// decrease attribute by 1
if ($action == "dec") {
    
    //update the attribute
    $new_value = $cur_value - 1;
    $sql = "UPDATE characters SET $attr = $new_value WHERE charid = $charid";
    $db->exec($sql);

    //calculate and log xp costs
    $xp_cost = $cur_value * -2;
    $userid = $_SESSION["userid"];
    $attrname = strtoupper($attr);
    $reason = "Attribut $attrname auf $new_value gesenkt.";
    $sql = "INSERT INTO xplog (charid, userid, xp, reason) VALUES ($charid, $userid, $xp_cost, '$reason')";
    $db->exec($sql);
}

include "_getxp.php";
$xp = getXP($db, $charid);

$result = [];
$result["attr"] = $attr;
$result["value"] = $new_value;
$result["xp"] = $xp;

$result = json_encode($result);
echo $result;

?>