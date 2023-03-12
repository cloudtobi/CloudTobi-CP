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
  <link rel="apple-touch-icon" sizes="180x180" href="/dist/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/dist/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/dist/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="/dist/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="/dist/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
</head>
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
      <form action="Pinlogin.php" method="post">
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="pin" placeholder="PIN" id="pin" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4 mx-auto">
            <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
          </div>
        </div>
        <br>
        <div style="text-align:center;">
                <a href="Login">Anmelden mit Passwort</a>
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
