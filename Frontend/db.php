<?php
$host = "localhost";
$user = "problemfixersjed";
$pass = "lol";
$dbname = "dad";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
