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
    <title>Nový ticket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Vytvořit nový ticket</h2>
    <form action="submit_ticket.php" method="post">
        <input type="text" name="subject" placeholder="Předmět" required>
        <textarea name="description" placeholder="Popis problému" required></textarea>
        <button type="submit">Odeslat</button>
    </form>
</body>
</html>