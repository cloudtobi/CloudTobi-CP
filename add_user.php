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
$rolle = mysqli_real_escape_string($conn, $_POST['role']);

// Das Passwort hashen
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL-Abfrage zum Einfügen des neuen Benutzers
$sql = "INSERT INTO accounts (username, email, password, rolle) VALUES ('$username', '$email', '$hashed_password', '$rolle')";
if (mysqli_query($conn, $sql)) {
  //-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
session_start();                                                                                                            
if (!isset($_SESSION['loggedin'])) {                                                                                        
	header('Location: index.html');
	exit;
}
include 'datenbank_verbindung.php';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$stmt = $con->prepare('SELECT username FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

function logMessage($message, $priority, $username) {
    include 'datenbank_verbindung.php';
    $mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $username = $mysqli->real_escape_string($username);
    $message = $mysqli->real_escape_string($message);
    $priority = $mysqli->real_escape_string($priority);
    $now = date("d-m-Y H:i:s");
    $query = "INSERT INTO logs (user_id, message, priority, created_at) VALUES ('$username', '$message', '$priority','$now')";
    $mysqli->query($query);
    $mysqli->close();
  }
  logMessage('hat einen neuen User erstellt', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
  // Weiterleitung zur home.php-Seite nach erfolgreicher Ausführung
  // Erfolgsmeldung in Session-Variable speichern
  $_SESSION['success_message'] = "Benutzer hinzugefügt.";
  header("Location: user-management.php");
  exit();
} else {
  echo "Fehler: " . $sql . "<br>" . mysqli_error($conn);
}

// Verbindung zur Datenbank schließen
mysqli_close($conn);
?>
