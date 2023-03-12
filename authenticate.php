<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php
session_start();

require 'datenbank_verbindung.php';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) {
	exit('Fülle alle Felder aus!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password);
		$stmt->fetch();
		if (password_verify($_POST['password'], $password)) {
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			header('Location: Home');			
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
  logMessage('hat sich angemeldet', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
		exit();
		} else {
			$_SESSION['error_message'] = "Falscher Benutzername oder Passwort.";
			header("Location: Login");
			exit();
		}
	} else {
		$_SESSION['error_message'] = "Falscher Benutzername oder Passwort.";
		header("Location: Login");
		exit();
	}

	$stmt->close();
}

if (isset($_SESSION['loggedin'])) {
	$stmt = $con->prepare('SELECT username FROM accounts WHERE id = ?');
	$stmt->bind_param('i', $_SESSION['id']);
	$stmt->execute();
	$stmt->bind_result($username);
	$stmt->fetch();
	$stmt->close();
}

?>