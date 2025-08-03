<?php
$de = [];
//general texts

//login.php
$de["h_login"] = "Bitte anmelden";
$de["h_login_success"] = "Anmeldung erfolgreich";
$de["h_login_failed"] = "Anmeldung fehlgeschlagen";
$de["h_logout"] = "Sitzung beendet";
$de["b_login"] = "Anmelden";
$de["b_username"] = "Benutzer";
$de["b_password"] = "Passwort";
$de["l_continue"] = "Weiter ...";

//_makeconfig.php
$de["h_enter_db_creds"] = "Zugangsdaten zur Datenbank ..."; 
$de["t_db_serv"] = "Datenbankserver: ";
$de["t_db_name"] = "Datenbankname: ";
$de["t_db_user"] = "Datenbanknutzer: ";
$de["t_db_pass"] = "Datenbankpasswort: ";
$de["b_create_config"] = "Konfigurationsdatei erstellen";
$de["t_db_success"] = "Datenbankverbindung erfolgreich ...";
$de["t_db_failed"] = "Datenbankverbindung fehlgeschlagen ...";
$de["h_db_init"] = "Datenbank wird initialisiert ...";
$de["t_db_done"] = "Datenbank bereit ...";
$de["t_db_fail"] = "Fehler bei Verbindung mit Datenbank. Bitte Konfiguration prüfen ...";

//_installcomplete.php
$de["h_install_done"] = "Installation abgeschlossen";
$de["t_install_done"] = "Es sieht danach aus, als wäre die Installation erfolgreich abgeschlossen.<br/>
                         Die Datenbankverbindung wurde erfolgreich hergestellt und ein Besitzerbenutzer angelegt.<br/>
                         Um die Seite neu anzulegen, muss die <i>config.php</i> gelöscht und das Installationsskript erneut aufgerufen werden.<br/>
                         Aus Sicherheitsgründen wurde das Installationsskript zu <i>install.bak</i> umbenannt.";
$de["l_to_site"] = "Zur Webseite ...";

//_createadmin.php
//register.php
$de["h_register_owner"] = "Besitzerkonto anlegen ...";
$de["t_username"] = "Benutzer: ";
$de["t_password"] = "Passwort: ";
$de["t_mail"] = "E-Mail: ";
$de["b_register"] = "Registrieren ...";
$de["h_owner_exists"] = "Besitzerkonto erfolgreich angelegt";
$de["t_ownerinfo"] = "Der Benutzer <i>OWNER</i> ist als Besitzer der Seite registriert.";



$en = [];

$M = $de;
unset($de);
unset($en);
?>
