<?php
if (isset($_SESSION["userid"])) {
    echo "<p><a href='characters.php'>Charaktere</a> - Angemeldet als {$_SESSION["username"]} - <a href='login.php?logout'>Abmelden</a>
    </p>";
} else {
?>
<form method="POST" action="login.php">
    <input placeholder="Benutzer" name="user"/>
    <input placeholder="Passwort" name="pass" type="password"/>
    <input value="Anmelden" type="submit"/>
</form>
<?php
}
?>