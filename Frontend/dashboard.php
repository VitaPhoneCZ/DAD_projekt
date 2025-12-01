<?php
// Spuštění session
session_start();

// Načtení potřebných souborů
include 'components/db.php';
include 'components/post_login_header.php';

// Kontrola přihlášení uživatele
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || !isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Načtení dark mode z databáze
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT dark_mode FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $_SESSION['dark_mode'] = $row['dark_mode'];
}

// Uložení údajů uživatele
$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// SQL dotaz podle role
if ($role === 'it') {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, tickets.priority, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            WHERE tickets.status = 'Otevřený' 
            ORDER BY tickets.id DESC";
} else {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, tickets.priority, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            WHERE tickets.status = 'Otevřený' AND tickets.user_id = ?
            ORDER BY tickets.id DESC";
}

// Provedení dotazu
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
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="mb-4 text-primary">
                    <i class="fas fa-ticket-alt"></i> Otevřené tickety
                </h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Název</th>
                                <th>Priorita</th>
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
                                            // Barevné označení priorit
                                            $priority_colors = [
                                                'Nízká' => 'success',
                                                'Střední' => 'warning',
                                                'Vysoká' => 'danger'
                                            ];
                                            $priority_class = $priority_colors[$row['priority']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $priority_class ?> rounded-pill px-3 py-2"><?= htmlspecialchars($row['priority']) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td>
                                            <a href="ticket_detail.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                <i class="fas fa-eye"></i> Zobrazit
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