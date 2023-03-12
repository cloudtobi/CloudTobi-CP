<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CloudTobi | Log in</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<style>
    .hide-extension a::after {
        content: "";
    }
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a>CloudTobi</a>
  </div>
  <?php
session_start();
if (isset($_SESSION['error_message'])) {
	// Fehlermeldung ausgeben
	echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
	
	// Session-Variable zurücksetzen
	unset($_SESSION['error_message']);
}
?>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Melde dich hier an</p>
      <form action="authenticate.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Benutzername" id="username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Passwort" id="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4 mx-auto">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
