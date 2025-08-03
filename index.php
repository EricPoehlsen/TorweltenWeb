<?php 
include "_checklogin.php";
ini_set('display_errors', 1); ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
</head>
<body>
    <div id="userbar"><?php include "_userbar.php"; ?></div>
    <p>Hallo</p>

    <?php echo $_SESSION["userid"];?>
</body>
</html>
