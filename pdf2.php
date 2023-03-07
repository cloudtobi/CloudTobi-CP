<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<?php
    include 'datenbank_verbindung.php';
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
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
                <a href="home.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Report</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pdf.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PDF</p>
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
  <h1>PDF generieren</h1>
  <br>
	<form>
		<label for="eingabe1">Item:</label>
    <select id="eingabe1" name="eingabe1">
		<?php
      include 'datenbank_verbindung.php';
			$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

			$result = mysqli_query($conn, "SELECT no FROM items");

			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value='".$row['no']."'>".$row['no']."</option>";
			}

			mysqli_close($conn);
		?>
	</select><br><br>
		<label for="eingabe2">Eingabe 2:</label>
		<input type="text" id="eingabe2" name="eingabe2"><br><br>

		<label for="eingabe3">Eingabe 3:</label>
		<input type="text" id="eingabe3" name="eingabe3"><br><br>

		<button onclick="generatePDF()">PDF generieren</button>
	</form>

  <script>
		function generatePDF() {
			var eingabe1 = document.getElementById("eingabe1").value;
			var eingabe2 = document.getElementById("eingabe2").value;
			var eingabe3 = document.getElementById("eingabe3").value;

			// API-URL für QR-Code-Generierung
			var qrCodeAPI = "https://api.qr-code-generator.com/v1/create?access-token=rfbGmb_riZY2AkNvSwhxkQ087T54pxlTiX97Y3rECR1yWHgCCli7WvMTvsd4JCeD&data=" + eingabe3 + "&size=200x200";

			// Herunterladen des QR-Codes als Base64-String
			$.get(qrCodeAPI, function(data) {
				var qrCodeBase64 = data.replace(/^data:image\/(png|jpeg);base64,/, "");
				var qrCodeImage = { image: qrCodeBase64, width: 100, height: 100 };

				// PDF generieren
				var docDefinition = {
					content: [
						{ text: "Item Nr: " + eingabe1, style: 'header' },
						{ text: eingabe2, style: 'subheader' },
						qrCodeImage
					],
					styles: {
						header: {
							fontSize: 18,
							bold: true,
							alignment: 'center',
							margin: [0, 0, 0, 10]
						},
						subheader: {
							fontSize: 14,
							bold: true,
							alignment: 'center',
							margin: [0, 0, 0, 10]
						}
					}
				};

				pdfMake.createPdf(docDefinition).open();
			});
		}
	</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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

