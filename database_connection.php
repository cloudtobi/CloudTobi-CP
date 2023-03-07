<?php

//database_connection.php
include 'datenbank_verbindung.php';
$connect = new PDO("mysql:host=$DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME");

?>