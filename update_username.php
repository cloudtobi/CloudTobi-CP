<?php
session_start();
if (!isset($_SESSION['id'])) {
  // Benutzer ist nicht angemeldet, daher umleiten zur Anmeldeseite
  header('Location: home.php');
  exit();
}

require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Formular wurde abgeschickt, also versuchen, den Benutzernamen zu aktualisieren

  // Benutzereingabe validieren
  if (!isset($_POST['new_username']) || empty($_POST['new_username'])) {
    $_SESSION['error'] = 'Neuer Benutzername fehlt';
    header('Location: profile.php');
    exit();
  }

  // Benutzername aus der Formular-Eingabe holen
  $new_username = $_POST['new_username'];

  // Prüfen, ob der neue Benutzername bereits verwendet wird
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM accounts WHERE username = ? AND id <> ?');
  $stmt->execute([$new_username, $_SESSION['id']]);
  $count = $stmt->fetchColumn();

  if ($count > 0) {
    $_SESSION['error'] = 'Der Benutzername wird bereits verwendet';
    header('Location: profile.php');
    exit();
  }

  try {
    // Beginnen der Transaktion
    $pdo->beginTransaction();

    // Benutzernamen in der Datenbank aktualisieren
    $stmt = $pdo->prepare('UPDATE accounts SET username = ? WHERE id = ?');
    $stmt->execute([$new_username, $_SESSION['id']]);

    // Transaktion erfolgreich beenden
    $pdo->commit();
    // Erfolgsmeldung ausgeben und Popup-Fenster öffnen
    $_SESSION['success'] = 'Der Benutzername wurde erfolgreich aktualisiert';
    echo "<script>
      if(confirm('Der Benutzername wurde erfolgreich aktualisiert. Sie werden jetzt ausgeloggt.')) {
        window.location.href = 'logout.php';
      } else {
        window.location.href = 'profile.php';
      }
    </script>";
    exit();

    // Erfolgsmeldung ausgeben und zur Einstellungsseite zurückleiten
    $_SESSION['success'] = 'Der Benutzername wurde erfolgreich aktualisiert';
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
  logMessage('hat sein Benutzernamen geändert', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
  } catch (PDOException $e) {
    // Bei einem Fehler die Transaktion rückgängig machen
    $pdo->rollback();

    $_SESSION['error'] = 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.';
    header('Location: logout.php');
    exit();
  }

} else {
  // Zugriff auf diese Seite ist nur über das POST-Formular erlaubt
  header('Location: logout.php');
  exit();
}
?>
