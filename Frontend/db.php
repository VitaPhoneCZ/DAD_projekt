<?php
$host = "localhost";
$user = "root"; // Default user in XAMPP
$pass = ""; // Default password is empty
$dbname = "dad_db";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
