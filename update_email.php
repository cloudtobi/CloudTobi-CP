<?php
session_start();
if (!isset($_SESSION['id'])) {
  // Benutzer ist nicht angemeldet, daher umleiten zur Anmeldeseite
  header('Location: home');
  exit();
}

require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Formular wurde abgeschickt, also versuchen, die E-Mail-Adresse zu aktualisieren

  // Benutzereingabe validieren
  if (!isset($_POST['new_email']) || empty($_POST['new_email'])) {
    $_SESSION['error'] = 'Neue E-Mail-Adresse fehlt';
    header('Location: profile');
    exit();
  }

  // E-Mail-Adresse aus der Formular-Eingabe holen
  $new_email = $_POST['new_email'];

  // Prüfen, ob die neue E-Mail-Adresse bereits verwendet wird
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM accounts WHERE email = ? AND id <> ?');
  $stmt->execute([$new_email, $_SESSION['id']]);
  $count = $stmt->fetchColumn();

  if ($count > 0) {
    $_SESSION['error'] = 'Die E-Mail-Adresse wird bereits verwendet';
    header('Location: profile');
    exit();
  }

  try {
    // Beginnen der Transaktion
    $pdo->beginTransaction();

    // E-Mail-Adresse in der Datenbank aktualisieren
    $stmt = $pdo->prepare('UPDATE accounts SET email = ? WHERE id = ?');
    $stmt->execute([$new_email, $_SESSION['id']]);

    // Transaktion erfolgreich beenden
    $pdo->commit();

    // Erfolgsmeldung ausgeben und zur Einstellungsseite zurückleiten
    $_SESSION['success'] = 'Die E-Mail-Adresse wurde erfolgreich aktualisiert';
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
  logMessage('hat seine Emailadresse geändert', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
    // Erfolgsmeldung in Session-Variable speichern
    $_SESSION['success_message'] = "Email aktualisiert.";
    header('Location: profile');
    exit();
  } catch (PDOException $e) {
    // Bei einem Fehler die Transaktion rückgängig machen
    $pdo->rollback();

    $_SESSION['error'] = 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.';
    header('Location: profile');
    exit();
  }

} else {
  // Zugriff auf diese Seite ist nur über das POST-Formular erlaubt
  header('Location: profile');
  exit();
}
?>
