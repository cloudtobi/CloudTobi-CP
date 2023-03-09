<?php
session_start();

// Verbindung zur Datenbank herstellen
include 'datenbank_verbindung.php';
$host = $DATABASE_HOST; // Datenbankhost
$user = $DATABASE_USER; // Datenbankbenutzername
$password = $DATABASE_PASS; // Datenbankpasswort
$dbname = $DATABASE_NAME; // Datenbankname

// Verbindung zur Datenbank herstellen
$conn = mysqli_connect($host, $user, $password, $dbname);

// Überprüfen, ob das Formular abgeschickt wurde
if (isset($_POST['submit_delete'])) {
  // ID des zu löschenden Benutzers aus dem Formular lesen
  $id = $_POST['id'];

  // SQL-Abfrage zum Löschen des Benutzers mit der entsprechenden ID
  $sql = "DELETE FROM accounts WHERE id='$id'";
  mysqli_query($conn, $sql);

  // Prüfen, ob tatsächlich eine Zeile gelöscht wurde
  if (mysqli_affected_rows($conn) > 0) {
    // Erfolgsmeldung setzen
    $_SESSION['success_message'] = "Der Benutzer wurde erfolgreich gelöscht.";
  }
}

// Zurück zur Übersichtsseite
header("Location: user-management.php");
?>
