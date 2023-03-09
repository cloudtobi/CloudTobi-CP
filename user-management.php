<script type="text/javascript" src="redirecthome.js"></script>
<?php
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

$user_id = $_SESSION['id'];
$query = "SELECT rolle FROM accounts WHERE id = '$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
if($row['rolle'] != "admin") {
    echo '<div id="error-popup" style="display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);">
            <h2 style="margin-top: 0;">Fehler: Keine Berechtigung!</h2>
            <p>Du hast keine Berechtigung, diese Seite zu sehen.</p>
            <button onclick="redirectHome()" style="background-color: #007bff; color: #fff; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">OK</button>
          </div>';
    die();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CloudTobi | Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="home.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="profile.php" class="nav-link">Mein Profil</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Suche" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="home.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CloudTobi</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img widht="200" height="200" src="display_image.php?user_id=<?php echo $user_id; ?>" alt="Profilbild">
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?=$_SESSION['name']?></a>
        </div>
      </div>

      <div class="form-inline">
      <form method="get">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="q" placeholder="Suchen" aria-label="Search">
        </div>
        </form>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="home.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Report</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pdf.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PDF</p>
                </a>
              </li>
            </ul>
            <?php if (mysqli_num_rows($result) > 0) { ?>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="logs.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Logs</p>
              </a>
            </li>
            </ul>
            <?php } ?>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pdf.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Management</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>  
</div>
</section> 
</aside>
<br>
<section class="content">
<div style="margin: auto; width: fit-content;">
<!-- Button zum Hinzufügen eines neuen Benutzers -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-user-modal">+</button>
<br>
<!-- Modal zum Hinzufügen eines neuen Benutzers -->
<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="add-user-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="add_user.php">
        <div class="modal-header">
          <h5 class="modal-title" id="add-user-modal-label">Neuen Benutzer hinzufügen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="username-input">Benutzername:</label>
            <input type="text" class="form-control" id="username-input" name="username" required>
          </div>
          <div class="form-group">
            <label for="email-input">Email:</label>
            <input type="email" class="form-control" id="email-input" name="email" required>
          </div>
          <div class="form-group">
            <label for="password-input">Passwort:</label>
            <input type="password" class="form-control" id="password-input" name="password" required>
          </div>
          <div class="form-group">
            <label for="role-input">Rolle:</label>
            <input type="text" class="form-control" id="role-input" name="role" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
          <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
// Verbindung zur Datenbank herstellen
include 'datenbank_verbindung.php';
$host = $DATABASE_HOST; // Datenbankhost
$user = $DATABASE_USER; // Datenbankbenutzername
$password = $DATABASE_PASS; // Datenbankpasswort
$dbname = $DATABASE_NAME; // Datenbankname

// Verbindung zur Datenbank herstellen
$conn = mysqli_connect($host, $user, $password, $dbname);

// SQL-Abfrage zum Abrufen aller Benutzer
$sql = "SELECT id, username, email, rolle, notiz FROM accounts";
$result = mysqli_query($conn, $sql);

if (isset($_SESSION['success_message'])) {
  // Erfolgsmeldung ausgeben
  echo "<br><div class='alert alert-success'>".htmlspecialchars($_SESSION['success_message'])."</div>";
  
  // Session-Variable zurücksetzen
  unset($_SESSION['success_message']);
}
// Tabelle erstellen
echo "<br><table class='table'>";
echo "<thead><tr><th>ID</th><th>Benutzername</th><th>Email</th><th>Rolle</th><th>Notiz</th><th></th></tr></thead>";
echo "<tbody>";

// Daten der Benutzer in die Tabelle einfügen
while ($row = mysqli_fetch_assoc($result)) {
  $id = $row['id'];
  $username = $row['username'];
  $email = $row['email'];
  $rolle = $row['rolle'];
  $notiz = $row['notiz'];

  // Tabelleintrag erstellen
  echo "<tr>";
  echo "<form method='post' action='updated.php'>";
  echo "<input type='hidden' name='id' value='" . $id . "'>";
  echo "<td>" . $id . "</td>";
  echo "<td><input type='text' class='form-control' name='username' value='" . $username . "'></td>";
  echo "<td><input type='email' class='form-control' name='email' value='" . $email . "'></td>";
  echo "<td><input type='text' class='form-control' name='rolle' value='" . $rolle . "'></td>";
  echo "<td><input type='text' class='form-control' name='rolle' value='" . $notiz . "'></td>";
  echo "<td><input type='submit' class='btn btn-primary' name='submit_update' value='Speichern'></td>";
  echo "</form>";
  echo "</tr>";
}


echo "</tbody>";
echo "</table>";

// Verbindung zur Datenbank schließen
mysqli_close($conn);
?>

</div>
</section>
<br>      
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>

