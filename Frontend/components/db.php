<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dad_db";

// Vytvoření připojení k databázi
$conn = new mysqli($host, $user, $pass, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}
?>