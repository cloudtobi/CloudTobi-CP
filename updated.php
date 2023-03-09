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

if (isset($_POST['submit_update'])) {
  $id = $_POST['id'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $rolle = $_POST['rolle'];

  // SQL-Abfrage zum Aktualisieren des Benutzers
  $sql = "UPDATE accounts SET username='$username', email='$email', rolle='$rolle' WHERE id=$id";
  mysqli_query($conn, $sql);

  // Prüfen, ob tatsächlich eine Zeile aktualisiert wurde
  if (mysqli_affected_rows($conn) > 0) {
    // Erfolgsmeldung in Session-Variable speichern
    $_SESSION['success_message'] = "Benutzer aktualisiert.";
  
    // Weiterleitung zur anderen Seite
    header("Location: user-management.php");
    exit();
  }
}
?>