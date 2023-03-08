<?php
// Verbindung zur Datenbank herstellen
include 'datenbank_verbindung.php';
$host = $DATABASE_HOST; // Datenbankhost
$user = $DATABASE_USER; // Datenbankbenutzername
$password = $DATABASE_PASS; // Datenbankpasswort
$dbname = $DATABASE_NAME; // Datenbankname

// Verbindung zur Datenbank herstellen
$conn = mysqli_connect($host, $user, $password, $dbname);

// Benutzername, E-Mail-Adresse und Passwort aus dem Formular abrufen
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Das Passwort hashen
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL-Abfrage zum Einfügen des neuen Benutzers
$sql = "INSERT INTO accounts (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
if (mysqli_query($conn, $sql)) {
  // Weiterleitung zur home.php-Seite nach erfolgreicher Ausführung
  header("Location: user-management.php");
  exit();
} else {
  echo "Fehler: " . $sql . "<br>" . mysqli_error($conn);
}

// Verbindung zur Datenbank schließen
mysqli_close($conn);
?>
