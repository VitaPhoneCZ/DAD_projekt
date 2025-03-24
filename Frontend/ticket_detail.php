<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Připojení k databázi

// Ověření, zda je v URL parametr id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Neplatné ID ticketu.');
}

$ticket_id = intval($_GET['id']); // Ochrana proti SQL injection

// Dotaz na konkrétní ticket
$sql = "SELECT tickets.id, tickets.title, tickets.description, tickets.status, tickets.created_at, tickets.updated_at, users.name 
        FROM tickets 
        JOIN users ON tickets.user_id = users.id 
        WHERE tickets.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();

// Ověření, zda ticket existuje
if ($result->num_rows === 0) {
    die('Ticket nenalezen.');
}

$ticket = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Detail ticketu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <h2>Detail ticketu</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <td><?= $ticket['id'] ?></td>
        </tr>
        <tr>
            <th>Název</th>
            <td><?= htmlspecialchars($ticket['title']) ?></td>
        </tr>
        <tr>
            <th>Popis</th>
            <td><?= nl2br(htmlspecialchars($ticket['description'])) ?></td>
        </tr>
        <tr>
            <th>Stav</th>
            <td>
                <?php if ($ticket['status'] === 'open'): ?>
                    <span style="color: orange;">Otevřený</span>
                <?php else: ?>
                    <span style="color: green;">Uzavřený</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Vytvořil</th>
            <td><?= htmlspecialchars($ticket['name']) ?></td>
        </tr>
        <tr>
            <th>Vytvořeno</th>
            <td><?= $ticket['created_at'] ?></td>
        </tr>
        <tr>
            <th>Naposledy upraveno</th>
            <td><?= $ticket['updated_at'] ?></td>
        </tr>
    </table>

    <p><a href="index.php">← Zpět na seznam ticketů</a></p>

</body>
</html>
