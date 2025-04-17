<?php
session_start();
include 'db.php';
include 'header.php';

// Zkontroluj, jestli je uživatel přihlášen
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || !isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Načtení dark_mode z DB a uložení do session
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT dark_mode FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $_SESSION['dark_mode'] = $row['dark_mode'];
}

$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

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
    <title>Otevřené tickety | Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="s/style.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">

    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="mb-4 text-primary">Otevřené tickety</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
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
                                                    echo '<span class="badge bg-warning text-dark rounded-pill px-3 py-2">Otevřený</span>';
                                                } elseif ($row['status'] === 'Uzavřený') {
                                                    echo '<span class="badge bg-success rounded-pill px-3 py-2">Uzavřený</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary rounded-pill px-3 py-2">Neznámý</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td>
                                            <a href="ticket_detail.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                Zobrazit
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Žádné otevřené tickety</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
