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
  $sql = "SELECT * FROM accounts WHERE id = $user_id AND rolle = 'Admin'";
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css">
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
      <span class="brand-text font-weight-light">SAPD</span>
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
            <p>Dashboard</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="Report" class="nav-link active">
            <i class="fas fa-chart-bar"></i>
            <p>Report</p>
          </a>
        </li>
      </ul>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="PDF" class="nav-link">
              <i class="far fa-file-pdf"></i>
              <p>PDF</p>
            </a>
          </li>
        </ul>
      <?php if (mysqli_num_rows($result) > 0) { ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="Logs" class="nav-link">
            <i class="fas fa-clipboard-list"></i>
            <p>Logs</p>
          </a>
        </li>
      </ul>
      <?php } ?>
      <?php if (mysqli_num_rows($result) > 0) { ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="User-Management" class="nav-link">
            <i class="fas fa-users-cog"></i>
            <p>User Management</p>
          </a>
        </li>
      </ul>
      <?php } ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="logout" class="nav-link">
            <i class="fas fa-sign-out-alt"></i>
            <p>Abmelden</p>
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
  <style>
table.beamtenliste {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin: 0 auto;
  border: none;
  border-radius: 5px; 
  
}

td, th {
  border: none;
  text-align: left;
  padding: 12px;
  background: #f9f9f9;
}

th {
  background-color: #9e9e9e; 
  color: white;
  font-weight: bold;
  padding: 12px;
}

tr:hover {
  background-color: #f1f1f1;
}

.beamtenliste tr:nth-child(even) {
  background-color: #f2f2f2;
}

button {
  background-image: url('ms-excel-icon.png');
  background-repeat: no-repeat;
  background-position: center;
  background-size: contain;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  color: #ffffff;
  font-size: 16px;
  text-align: center;
}

button:hover {
  opacity: 0.8;
}
</style>


<button onclick="exportTableToExcel('items')" alt="Excel"></button>
<script>
function exportTableToExcel(items) {
  var tab_text="<table border='1px'><tr bgcolor='#87AFC6'>";
  var textRange; var j=0;
  tab = document.getElementById(items); 
  
  for(j = 0 ; j < tab.rows.length ; j++) {     
    tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
  }
  
  tab_text=tab_text+"</table>";
  tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, ""); 
  tab_text= tab_text.replace(/<img[^>]*>/gi,""); 
  tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, "");
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE "); 
  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      
  {
    txtArea1.document.open("txt/html","replace");
    txtArea1.document.write(tab_text);
    txtArea1.document.close();
    txtArea1.focus(); 
    sa=txtArea1.document.execCommand("SaveAs",true,"beamtenliste.xls");
  }  
  else                
  {
    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
  }
  return (sa);
}

</script>

<?php

  include 'datenbank_verbindung.php';
  $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT id, no, description, description2, unit FROM items";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<h2>Items</h2>";
    echo "<table id='items' border='1'><tr><th></th><th>Nummer</th><th>Beschreibung</th><th>Beschreibung2</th><th>Einheit</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["no"]."</td><td>".$row["description"]."</td> <td>".$row["description2"]."</td><td>".$row["unit"]."</td></tr>";
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>





</body>
</html>

