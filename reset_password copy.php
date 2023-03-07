<?php
// Verbindung zur Datenbank herstellen
include 'datenbank_verbindung.php';
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (!$conn) {
  die("Verbindung zur Datenbank fehlgeschlagen: " . mysqli_connect_error());
}

// Überprüfen, ob das Formular gesendet wurde
if(isset($_POST['submit'])) {
  // Abrufen des Benutzernamens und des eingegebenen Passworts aus dem Formular
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
  $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);

  // Abrufen des gespeicherten gehashten Passworts aus der Datenbank
  $sql = "SELECT password FROM accounts WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $hashed_password = $row['password'];

  // Überprüfen, ob das eingegebene Passwort mit dem gespeicherten gehashten Passwort übereinstimmt
  if(password_verify($current_password, $hashed_password)) {
    // Hashen des neuen Passworts
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Aktualisieren des Passworts in der Datenbank
    $sql = "UPDATE accounts SET password='$new_hashed_password' WHERE username='$username'";
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
  logMessage('hat sein Passwort geändert!', 'INFO', $username);
//-----------------------------------LOGGING SYSTEM------------------------------------------------------------------------------
    if(mysqli_query($conn, $sql)) {
      echo "Passwort wurde erfolgreich aktualisiert";
    } else {
      echo "Fehler beim Aktualisieren des Passworts: " . mysqli_error($conn);
    }
  } else {
    echo "Das eingegebene Passwort ist falsch";
  }
}

// Verbindung zur Datenbank schließen
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CloudTobi l Passwort Reset</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.html" class="h1">CloudTobi</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Hier kannst du dein Passwort ändern</p>
      <form method="post" action="reset_password.php">
        <div class="input-group mb-3">
          <input type="username" class="form-control" placeholder="Username" name="username" id="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Aktuelles Passwort" name="current_password" id="current_password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Neues Passwort" name="new_password" id="new_password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="submit" value="Reset Password" class="btn btn-primary btn-block">Passwort ändern</button>
          </div>
        </div>
      </form>
    
      <p class="mt-3 mb-1">
        <a href="home.php">Login</a>
      </p>
    </div>
  </div>
</div>

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
