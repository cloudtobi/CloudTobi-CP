<?php
// Konfiguration für die Datenbankverbindung
include 'datenbank_verbindung.php';
$db_host = $DATABASE_HOST;
$db_name = $DATABASE_NAME;
$db_user = $DATABASE_USER;
$db_pass = $DATABASE_PASS;

// Verbindung zur Datenbank herstellen
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
$pdo = new PDO($dsn, $db_user, $db_pass);

// PDO-Optionen setzen
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>