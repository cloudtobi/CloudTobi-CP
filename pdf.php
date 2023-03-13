<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: Login');
	exit;
}
?> 
<?php
  include 'datenbank_verbindung.php';
  $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  $user_id = $_SESSION['id'];
  $sql = "SELECT * FROM accounts WHERE id = $user_id AND rolle = 'admin'";
  $result = mysqli_query($con, $sql);
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
  <link rel="apple-touch-icon" sizes="180x180" href="/dist/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/dist/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/dist/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="/dist/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="/dist/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
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
        <a href="Home" class="nav-link">Home</a>
      </li>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="Profil" class="nav-link">Mein Profil</a>
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
    <a href="home" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CloudTobi</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img widht="200" height="200" src="display_image?user_id=<?php echo $user_id; ?>" alt="Profilbild">
        </div>
        <div class="info">
          <a href="Profil" class="d-block"><?=$_SESSION['name']?></a>
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
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="Home" class="nav-link">
            <i class="fas fa-tachometer-alt"></i>
            <p> Dashboard</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="Report" class="nav-link">
            <i class="fas fa-chart-bar"></i>
            <p> Report</p>
          </a>
        </li>
      </ul>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="PDF" class="nav-link active">
              <i class="far fa-file-pdf"></i>
              <p> PDF</p>
            </a>
          </li>
        </ul>
      <?php if (mysqli_num_rows($result) > 0) { ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="Logs" class="nav-link">
            <i class="fas fa-clipboard-list"></i>
            <p> Logs</p>
          </a>
        </li>
      </ul>
      <?php } ?>
      <?php if (mysqli_num_rows($result) > 0) { ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="User-Management" class="nav-link">
            <i class="fas fa-users-cog"></i>
            <p> User Management</p>
          </a>
        </li>
      </ul>
      <?php } ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="logout" class="nav-link">
            <i class="fas fa-sign-out-alt"></i>
            <p> Abmelden</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
    </div>
  </aside>
<section class="content">
  <div style="margin: auto; width: fit-content;">
    <h2 style="text-align: center;">PDF</h2>
      <style>

      #qr_code {
        display: none;
      }
    </style>

    <div>
      <label for="qr-text">QR Code Link:</label>
      <input type="text" id="qr-text" value="">
    </div>
    <br>
    <div>
      <label for="title-text">Beschreibung1:</label>
      <input type="text" id="title-text" value="">
    </div>
    <br>
    <div>
      <label for="description-text">Beschreibung2:</label>
      <input type="text" id="description-text" value="">
    </div>
    <br>
    <div>
      <label for="pdf-option">PDF Option:</label>
      <select id="pdf-option">
        <option value="new-tab">Browser</option>
        <option value="download">Download</option>
      </select>
    </div>
<br>
    <div style="text-align: center;">
      <button class="btn btn-primary" id="download"><i class="fas fa-print"></i> Druck</button>
    </div>
    <div id="qr_code"></div>
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
</div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2023.</strong>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="plugins/qr/qr.js"></script>

</body>
</html>

