<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Připojení k databázi

// Načtení všech ticketů bez ohledu na stav
$sql = "SELECT tickets.id, tickets.title, tickets.status, users.name 
        FROM tickets 
        JOIN users ON tickets.user_id = users.id 
        ORDER BY tickets.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Seznam ticketů</title>
    <link rel="stylesheet" href="s/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <h2>Seznam ticketů</h2>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Název</th>
                <th>Stav</th>
                <th>Vytvořil</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td>
                            <?php if ($row['status'] === 'open'): ?>
                                <span style="color: orange;">Otevřený</span>
                            <?php else: ?>
                                <span style="color: green;">Uzavřený</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <a href="ticket_detail.php?id=<?= $row['id'] ?>">Zobrazit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Žádné tickety k zobrazení</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
