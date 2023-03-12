<?php

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: Login');
	exit;
}
// Verbindung mit der Datenbank herstellen
include 'datenbank_verbindung.php';
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Abfrageparameter aus der URL abrufen
$user_id = $_SESSION['id'];

// SQL-Abfrage ausführen, um das Profilbild aus der Datenbank abzurufen
$result = mysqli_query($db, "SELECT image_path FROM profile_images WHERE user_id=$user_id");

// Das erste Ergebnis der Abfrage in einem Array speichern
$image_path = mysqli_fetch_array($result);

// Den Inhalt des Bildes in den HTTP-Header des Antwortschreibens einfügenss
header("Content-type: image/jpeg");

// Das Bild ausgeben
echo file_get_contents($image_path['image_path']);

// Verbindung mit der Datenbank schließen
mysqli_close($db);
?>