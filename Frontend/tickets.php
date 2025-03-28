<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Připojení k databázi

$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id']; // Předpokládám, že máš uložené ID přihlášeného uživatele

// SQL dotaz podle role uživatele
if ($role === 'it') {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, tickets.priority, tickets.platform, tickets.created_at, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            ORDER BY tickets.created_at DESC";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, tickets.priority, tickets.platform, tickets.created_at, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            WHERE tickets.user_id = ?
            ORDER BY tickets.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
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
                <th>Priorita</th>
                <th>Platforma</th>
                <th>Vytvořil</th>
                <th>Vytvořeno</th>
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
                            <?php if ($row['status'] === 'Otevřený'): ?>
                                <span style="color: green;">Otevřený</span>
                            <?php else: ?>
                                <span style="color: red;">Uzavřený</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['priority']) ?></td>
                        <td><?= htmlspecialchars($row['platform']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <a href="ticket_detail.php?id=<?= $row['id'] ?>">Zobrazit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">Žádné tickety k zobrazení</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
