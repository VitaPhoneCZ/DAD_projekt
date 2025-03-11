<?php
$host = "localhost";
$user = "root"; // Default user in XAMPP
$pass = ""; // Default password is empty
$dbname = "ticket_system";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
