<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Verbindung zur Datenbank herstellen
  include 'datenbank_verbindung.php';
  $db = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Prüfen, ob der Benutzer bereits ein Profilbild hat  
  $user_id = $_SESSION['id'];
  $result = $db->query("SELECT * FROM profile_images WHERE user_id = $user_id");
  if ($result->num_rows) {
    // Aktualisieren des Profilbildpfads in der Datenbank
    $image_path = $db->escape_string('profilpictures/' . $_FILES['image']['name']);
    $db->query("UPDATE profile_images SET image_path = '$image_path' WHERE user_id = $user_id");
  } else {
    // Einfügen einer neuen Zeile in die Tabelle
    $image_path = $db->escape_string('profilpictures/' . $_FILES['image']['name']);
    $db->query("INSERT INTO profile_images (user_id, image_path) VALUES ($user_id, '$image_path')");
  }

  // Speichern Sie das Bild auf dem Server
  move_uploaded_file($_FILES['image']['tmp_name'], 'profilpictures/' . $_FILES['image']['name']);
// LOGGING SYSTEM ----------------------------------------------------------------------------------------------------------
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
  logMessage('hat sein Profilbild geändert', 'INFO', $username);
// LOGGING SYSTEM ----------------------------------------------------------------------------------------------------------
  // Leiten Sie den Benutzer zurück zur Profilseite
  // Erfolgsmeldung in Session-Variable speichern
  $_SESSION['success_message'] = "Profilbild aktualisiert.";
  header('Location: /profile');
  exit;
}
?>
