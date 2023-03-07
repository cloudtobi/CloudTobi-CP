<?php
include 'datenbank_verbindung.php';
// Versuch die Verbindung herzustellen
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// Wenn ein Fehler bei der Verbindung auftritt, halten Sie das Skript an und zeigen den Fehler an.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Jetzt prüfen wir, ob die Daten übermittelt wurden. Die Funktion isset() prüft, ob die Daten existieren.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Die Daten, die gesendet werden sollten, konnten nicht abgerufen werden.
	exit('Bitte vervollständige deine Angaben!');
}
// Stellen Sie sicher, dass die übermittelten Registrierungswerte nicht leer sind.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// Ein oder mehrere Werte sind leer.
	exit('Bitte vervollständige deine Angaben!');
}

// Wir müssen prüfen, ob das Konto mit diesem Benutzernamen existiert.
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email ist nicht gültig!');
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username ist nicht gültig!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Dein Passwort muss zwischen 5 und 20 Zeichen lang sein!');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Binden Sie Parameter (s = string, i = int, b = blob, usw.) und hacken Sie das Passwort mit der PHP-Funktion password_hash.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Speichern Sie das Ergebnis, damit wir prüfen können, ob das Konto in der Datenbank existiert.
	if ($stmt->num_rows > 0) {
		// Benutzername existiert bereits
		echo 'Benutzername existiert bereits, bitte nutze einen anderen!';
	} else {
		// Benutzername existiert nicht, neues Konto einfügen
		if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
	// Wir wollen keine Passwörter in unserer Datenbank offenlegen, also hashen wir das Passwort und verwenden password_verify, wenn sich ein Benutzer anmeldet.
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$uniqid = uniqid();
	$stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
	$stmt->execute();
	echo 'Du hast dich erfolgreich registriert. Du kannst nich nun einloggen!';
} else {
	// Irgendetwas stimmt nicht mit der Sql-Anweisung, prüfen Sie, ob die Tabelle accounts mit allen 3 Feldern existiert.
	echo 'Could not prepare statement!';
}
	}
	$stmt->close();
} else {
	// Irgendetwas stimmt nicht mit der Sql-Anweisung, prüfen Sie, ob die Tabelle accounts mit allen 3 Feldern existiert.
	echo 'Could not prepare statement!';
}
$con->close();
?>