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
      <span class="brand-text font-weight-light">SAPD</span>
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
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="logs.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Logs</p>
                </a>
              </li>
            </ul>
            <?php if (mysqli_num_rows($result) > 0) { ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="user-management.php" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>User Management</p>
          </a>
        </li>
      </ul>
      <?php } ?>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <section class="content">
  <div style="margin: auto; width: fit-content;">
  <?php

  include 'datenbank_verbindung.php';
  $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT log_id, user_id, message, priority, created_at FROM logs";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>User</th><th>Nachricht</th><th>Priorität</th><th>Erstellt am:</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["log_id"]."</td><td>".$row["user_id"]."</td> <td>".$row["message"]."</td><td>".$row["priority"]."</td><td>".$row["created_at"]."</td></tr>";
    }
    echo "</table>";
  } else {
    echo "Keine Ergebnisse";
  }
  $conn->close();
  ?>
  </div>
</section>

</div>

  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
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

