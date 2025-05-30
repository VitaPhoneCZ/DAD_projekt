<?php
// Spuštění session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kontrola přihlášení uživatele
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

// Načtení potřebných souborů
include __DIR__ . '/components/db.php';
include __DIR__ . '/components/post_login_header.php';

// Získání údajů uživatele
$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Příprava SQL dotazu podle role
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam ticketů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : 'bg-light' ?>">
    <!-- Tabulka se seznamem ticketů -->
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-primary mb-0">Seznam ticketů</h2>
                    <?php if ($role === 'it'): ?>
                        <a href="components/exporttickets.php" class="btn btn-success rounded-pill">Exportovat do Excelu</a>
                    <?php endif; ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
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
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['title']) ?></td>
                                        <td>
                                            <?php if ($row['status'] === 'Otevřený'): ?>
                                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Otevřený</span>
                                            <?php else: ?>
                                                <span class="badge bg-success rounded-pill px-3 py-2">Uzavřený</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $priority_colors = [
                                                'Nízká' => 'success',
                                                'Střední' => 'warning',
                                                'Vysoká' => 'danger'
                                            ];
                                            $priority_class = $priority_colors[$row['priority']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $priority_class ?> rounded-pill px-3 py-2"><?= htmlspecialchars($row['priority']) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($row['platform']) ?></td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                                        <td>
                                            <a href="ticket_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Zobrazit</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Žádné tickety k zobrazení</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>