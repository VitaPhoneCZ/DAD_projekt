<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Připojení k databázi

// Získání hodnot z formuláře
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$urgency = isset($_POST['urgency']) ? $_POST['urgency'] : 'low'; // Defaultní hodnota je nízká urgenci

// Získání user_id ze session
$user_id = $_SESSION['user_id']; // Předpokládám, že máš uložené user_id v session

// Ověření, zda uživatel je přihlášen a má user_id
if (!$user_id) {
    die('Uživatel není přihlášen nebo není k dispozici user_id.');
}

// Příprava SQL dotazu pro vložení nového ticketu
$sql = "INSERT INTO tickets (user_id, title, description, urgency, created_at) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

// Binding parametrů
$stmt->bind_param("isss", $user_id, $subject, $description, $urgency);

// Spuštění dotazu
if ($stmt->execute()) {
    echo "Ticket byl úspěšně vytvořen.";
    header('Location: tickets.php'); // Přesměrování zpět na seznam ticketů
    exit();
} else {
    echo "Chyba při vytváření ticketu: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
