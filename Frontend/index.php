<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Vítejte na hlavní stránce</h2>
    <a href="new_ticket.php">Vytvořit nový ticket</a>
    <a href="tickets.php">Seznam ticketů</a>
</body>
</html>