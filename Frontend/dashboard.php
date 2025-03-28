<?php
session_start();
include 'db.php';
include 'header.php'; // Zahrnutí headeru a kontroly session

// Zkontroluj, jestli je uživatel přihlášen
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id']; // Předpokládám, že máš uložené ID přihlášeného uživatele

// SQL dotaz podle role uživatele
if ($role === 'it') {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            WHERE tickets.status = 'Otevřený' 
            ORDER BY tickets.id ASC";
} else {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            WHERE tickets.status = 'Otevřený' AND tickets.user_id = ?
            ORDER BY tickets.id ASC";
}

$stmt = $conn->prepare($sql);

if ($role !== 'it') {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
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
                            <td>
                                <?php 
                                    if ($row['status'] === 'Otevřený') {
                                        echo '<span class="badge bg-warning">Otevřený</span>';
                                    } elseif ($row['status'] === 'Uzavřený') {
                                        echo '<span class="badge bg-success">Uzavřený</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">Neznámý</span>';
                                    }
                                ?>
                            </td>
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
