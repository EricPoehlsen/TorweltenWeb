<?php
if (isset($_SESSION["userid"])) {
    echo "<p>Logged in</p>";
} else {
    ?>
<form method="POST" action="login.php">
    <input placeholder="username" name="user"/>
    <input placeholder="password" name="pass" type="password"/>
    <input value="login" type="submit"/>
</form>
    <?php
}
?>
