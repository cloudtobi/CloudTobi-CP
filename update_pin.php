<?php
session_start();
if (!isset($_SESSION['id'])) {
  // Benutzer ist nicht angemeldet, daher umleiten zur Anmeldeseite
  header('Location: home');
  exit();
}

require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Formular wurde abgeschickt, also versuchen, die Notiz zu aktualisieren

  // Benutzereingabe validieren
  if (!isset($_POST['new_pin']) || empty($_POST['new_pin'])) {
    $_SESSION['error'] = 'Neuer Pin fehlt';
    header('Location: Profil');
    exit();
  }

  // E-Mail-Adresse aus der Formular-Eingabe holen
  $new_pin = $_POST['new_pin'];

  try {
    // Beginnen der Transaktion
    $pdo->beginTransaction();

    // E-Mail-Adresse in der Datenbank aktualisieren
    $stmt = $pdo->prepare('UPDATE accounts SET pin = ? WHERE id = ?');
    $stmt->execute([$new_pin, $_SESSION['id']]);

    // Transaktion erfolgreich beenden
    $pdo->commit();

    // Erfolgsmeldung ausgeben und zur Einstellungsseite zurückleiten
    $_SESSION['success'] = 'Der PIN wurde erfolgreich aktualisiert';
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
  logMessage('hat seine Notiz geändert', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
    // Erfolgsmeldung in Session-Variable speichern
    $_SESSION['success_message'] = "PIN aktualisiert.";
    header('Location: Profil');
    exit();
  } catch (PDOException $e) {
    // Bei einem Fehler die Transaktion rückgängig machen
    $pdo->rollback();

    $_SESSION['error'] = 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.';
    header('Location: Profil');
    exit();
  }

} else {
  // Zugriff auf diese Seite ist nur über das POST-Formular erlaubt
  header('Location: Profil');
  exit();
}
?>
