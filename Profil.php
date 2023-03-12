<?php
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
$stmt = $con->prepare('SELECT pin, email, rolle, notiz FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($pin, $email, $rolle, $notiz);
$stmt->fetch();
$stmt->close();
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
  <title>User Profil</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="apple-touch-icon" sizes="180x180" href="/dist/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/dist/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/dist/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="/dist/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="/dist/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
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
      <li class="nav-item d-none d-sm-inline-block">
        <a href="logout" class="nav-link">Abmelden</a>
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
              <input class="form-control form-control-navbar" type="search" placeholder="Suchen" aria-label="Search">
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
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Suchen" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
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
          <a href="Home" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="Report" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Report</p>
          </a>
        </li>
      </ul>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="PDF" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>PDF</p>
            </a>
          </li>
        </ul>
      <?php if (mysqli_num_rows($result) > 0) { ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="Logs" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Logs</p>
          </a>
        </li>
      </ul>
      <?php } ?>
      <?php if (mysqli_num_rows($result) > 0) { ?>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="User-Management" class="nav-link">
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

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">User Profil</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
    <?php
      if (isset($_SESSION['success_message'])) {
      // Erfolgsmeldung ausgeben
      echo "<br><div id='success-message' class='alert alert-success'>".htmlspecialchars($_SESSION['success_message'])."</div>";
  
      // Session-Variable zurücksetzen
      unset($_SESSION['success_message']);
    }
    ?>
        <script>
          // Verstecke die Erfolgsmeldung nach 5 Sekunden
          setTimeout(function() {
          var successMessage = document.getElementById('success-message');
          successMessage.style.display = 'none';
          }, 5000); // 5000 Millisekunden = 5 Sekunden
        </script>


      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-Profil">
              <h1 class="text-center"><?=$_SESSION['name']?><h1>
                <div class="text-center">
                <img widht="200" height="200" src="display_image?user_id=<?php echo $user_id; ?>" alt="Profilbild">
                </div>
                <br>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Einstellungen</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  <div>
				<p>Hier sind deine Informationen:</p>
        <style>
          table tr {
          line-height: 2em;
          }
          </style>
				<table>
					<tr>
						<td>Benutzername:</td>
            <td><?=$_SESSION['name']?> <a href="#" data-toggle="modal" data-target="#edit-username-modal"><i class="fas fa-pencil-alt"></i></a></td>
          </tr>
					<tr>
						<td>Email:</td>
            <td><?=$email?> <a href="#" data-toggle="modal" data-target="#edit-email-modal"><i class="fas fa-pencil-alt"></i></a></td>
					</tr>
          <tr>
						<td>PIN:</td>
            <td><?=$pin?> <a href="#" data-toggle="modal" data-target="#edit-pin-modal"><i class="fas fa-pencil-alt"></a></td>
					</tr>
          <tr>
						<td>Berechtigungen:</td>
            <td><?=$rolle?> <a href="#" data-toggle="modal" data-target=""></a></td>
					</tr>
          <tr>
						<td>Notiz:</td>
            <td><?=$notiz?> <a href="#" data-toggle="modal" data-target="#edit-notiz-modal"><i class="fas fa-pencil-alt"></a></td>
					</tr>
				</table>
			</div>
      <!-- Modal zum Bearbeiten des Benutzernamens -->
<div class="modal fade" id="edit-username-modal" tabindex="-1" role="dialog" aria-labelledby="edit-username-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="update_username">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-username-modal-label">Benutzernamen ändern</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="new-username-input">Neuer Benutzername:</label>
            <input type="text" class="form-control" id="new-username-input" name="new_username" required>
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

      <!-- Modal zum Bearbeiten des PIN -->
      <div class="modal fade" id="edit-pin-modal" tabindex="-1" role="dialog" aria-labelledby="edit-pin-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="update_pin">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-pin-modal-label">PIN ändern</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="new-pin-input">Neuer PIN:</label>
            <input type="text" class="form-control" id="new-pin-input" name="new_pin" required>
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
      <!-- Modal zum Bearbeiten der Email -->
      <div class="modal fade" id="edit-email-modal" tabindex="-1" role="dialog" aria-labelledby="edit-email-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="update_email">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-email-modal-label">Emailadresse ändern</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="new-email-input">Neue Email:</label>
            <input type="email" class="form-control" id="new-email-input" name="new_email" required>
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

      <!-- Modal zum Bearbeiten der Notiz -->
      <div class="modal fade" id="edit-notiz-modal" tabindex="-1" role="dialog" aria-labelledby="edit-notiz-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="update_notiz">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-notiz-modal-label">Notiz ändern</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="new-email-input">Neue Notiz:</label>
            <input type="text" class="form-control" id="new-notiz-input" name="new_notiz" required>
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
          <style>
              input[type=submit] {
        background-color: #007BFF;
        border: none;
        color: white;
        padding: 10px 40px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
      }
            input[type=submit]:hover {
        background-color: #0466cf;
        }
        input[type=file] {
        background-color: #007BFF;
        border: none;
        color: white;
        padding: 10px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
      }
      input[type=file]:hover {
          background-color: #0466cf;
      }
            </style>
                      <p class="mt-3 mb-1">
            <a href="reset_password">Passwort zurücksetzen</a>
          </p><br>
          <form method="post" action="upload_profile_image" enctype="multipart/form-data">
          <label for="image">Profilbild:</label><br>
          <input type="file" accept="image/*" name="image" id="image"><br>
          <br>
          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
          <input type="submit" name="submit" value="Hochladen">
          </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2023.</strong> All rights reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
