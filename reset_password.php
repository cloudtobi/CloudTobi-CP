<?php
// Connect to the database
include 'datenbank_verbindung.php';  
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check for form submission
if (isset($_POST['submit'])) {
  $username = $db->real_escape_string($_POST['username']);
  $current_password = $db->real_escape_string($_POST['current_password']);
  $new_password = $db->real_escape_string($_POST['new_password']);

  // Retrieve the user's current password hash from the database
  $query = "SELECT password FROM accounts WHERE username = '$username'";
  $result = $db->query($query);
  $row = $result->fetch_assoc();
  $current_password_hash = $row['password'];

  // Check if the current password is correct
  if (password_verify($current_password, $current_password_hash)) {
    // The current password is correct, so update the password in the database
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $query = "UPDATE accounts SET password = '$new_password_hash' WHERE username = '$username'";
    $result = $db->query($query);
    if ($result) {
      echo 'Dein Passwort wurde erfolgreich geändert';
    } else {
      echo 'Es ist ein Fehler aufgetreten!';
    }
  } else {
    // The current password is incorrect
    echo 'Das aktuelle Passwort ist nicht korrekt!';
  }
}

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
