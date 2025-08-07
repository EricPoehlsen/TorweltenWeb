<?php 

// retrieve the total xp cost of a character from the database
function getXP($db, $charid) {
    $xp = 0;
    
    $sql = "SELECT xp FROM xplog WHERE charid = $charid";
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        $xp += $row["xp"];
    }
    return $xp;
}
?>