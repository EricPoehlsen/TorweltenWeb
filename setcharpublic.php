<?php 
include "_checklogin.php";

// this code retrieves the skill list from the server

  // connect DB
include "config.php";
$dsn = "mysql:dbname=$db_name;host=$db_serv";
$db = new PDO($dsn, $db_user, $db_pass);

//get data
$charid = $_POST["charid"];
$public = $_POST["public"];

//ACL check
$edit = false;
$sql = "SELECT userid, editors FROM characters WHERE charid = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$charid]);
$c = $stmt->fetch();
$editors = explode(",", $c["editors"]);
$owner = $c["userid"];
if (in_array($_SESSION["userid"], $editors)) $edit = true;
if ($_SESSION["userid"] == $owner) $edit = true;
if (!$edit) die;

// Update the data
if ($public == "true") {
    $sql = "UPDATE `characters` SET `public`=1 WHERE `charid`=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$charid]);
} else {
    $sql = "UPDATE `characters` SET `public`=0 WHERE `charid`=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$charid]);
}


