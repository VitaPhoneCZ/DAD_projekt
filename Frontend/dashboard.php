<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Vítejte na hlavním panelu</h2>
    <a href="new_ticket.php">Vytvořit nový ticket</a>
    <a href="tickets.php">Seznam ticketů</a>
    <a href="logout.php">Odhlásit se</a>
</body>
</html>