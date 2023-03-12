<?php
session_start();

// Verbindung zur Datenbank herstellen
require 'datenbank_verbindung.php';
$host = $DATABASE_HOST;
$user = $DATABASE_USER;
$password = $DATABASE_PASS;
$database = $DATABASE_NAME;
$connection = mysqli_connect($host, $user, $password, $database);

// Überprüfen, ob das Formular abgesendet wurde und der PIN-Code gesetzt ist
if(isset($_POST['pin']) && !empty($_POST['pin'])){
  // PIN-Code aus dem Formular lesen
  $pin = $_POST["pin"];

  // SQL-Abfrage vorbereiten und ausführen
  $sql = "SELECT * FROM accounts WHERE pin = '$pin'";
  $result = mysqli_query($connection, $sql);

  // Überprüfen, ob ein Benutzer mit diesem PIN-Code gefunden wurde
  if (mysqli_num_rows($result) == 1) {
    // Benutzer gefunden - Login erfolgreich
    $row = mysqli_fetch_assoc($result);

    // Session starten und Benutzerdaten speichern
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['id'] = $row['id'];

    // Abfrage, um Benutzername zu erhalten
    $stmt = $connection->prepare('SELECT id, username FROM accounts WHERE id = ?');
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($id, $username);
    $stmt->fetch();
    $stmt->close();
    
    $_SESSION['name'] = $username;
    // Weiterleitung zur Startseite
    header("Location: Home");
    //-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
session_start();                                                                                                            
if (!isset($_SESSION['loggedin'])) {                                                                                        
	header('Location: Login');
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
  logMessage('hat sich mit PIN angemeldet', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
    exit;
  } else {
    // Benutzer nicht gefunden - Login fehlgeschlagen
    $_SESSION['error_message'] = "Falscher PIN.";
    header("Location: PIN");
    exit();
  }
}

// Verbindung zur Datenbank schließen
mysqli_close($connection);
?>