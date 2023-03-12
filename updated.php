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
  $notiz = $_POST['notiz'];

  // SQL-Abfrage zum Aktualisieren des Benutzers
  $sql = "UPDATE accounts SET username='$username', email='$email', rolle='$rolle', notiz='$notiz' WHERE id=$id";
  mysqli_query($conn, $sql);

  // Prüfen, ob tatsächlich eine Zeile aktualisiert wurde
  if (mysqli_affected_rows($conn) > 0) {
    // Erfolgsmeldung in Session-Variable speichern
    $_SESSION['success_message'] = "Benutzer aktualisiert.";
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
  logMessage('hat einen User geändert', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
    // Weiterleitung zur anderen Seite
    header("Location: user-management");
    exit();
  }
}
?>