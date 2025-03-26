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
    <link rel="stylesheet" href="s/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Vytvořit nový ticket</h2>
    <form action="submit_ticket.php" method="post">
        <input type="text" name="subject" placeholder="Předmět" required>
        <textarea name="description" placeholder="Popis problému" required></textarea>

        <!-- Výběr urgence ticketu -->
        <label for="urgency">Urgence:</label>
        <select name="urgency" id="urgency" required>
            <option value="low">Nízká</option>
            <option value="medium">Střední</option>
            <option value="high">Vysoká</option>
        </select>

        <button type="submit">Odeslat</button>
    </form>
</body>
</html>
