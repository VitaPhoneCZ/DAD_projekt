<?php
session_start();
include 'db.php';
include 'header.php'; // Zahrnutí headeru a kontroly session

// Zkontroluj, jestli je uživatel přihlášen
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Získání otevřených ticketů
$sql = "SELECT tickets.id, tickets.title, tickets.status, users.name 
        FROM tickets 
        JOIN users ON tickets.user_id = users.id 
        WHERE tickets.status = 'open' 
        ORDER BY tickets.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavní stránka | Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="s/style.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Otevřené tickety</h2>
        <table class="table table-bordered">
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
                            <td><span class="badge bg-warning"><?= $row['status'] ?></span></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><a href="ticket_detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Zobrazit</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Žádné otevřené tickety</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
