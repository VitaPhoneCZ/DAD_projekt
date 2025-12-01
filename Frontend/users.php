<?php
// Spuštění session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kontrola přihlášení a role uživatele
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'it') {
    $_SESSION['error'] = 'Nemáte oprávnění zobrazit tuto stránku.';
    header('Location: login.php');
    exit();
}

// Načtení potřebných souborů
include __DIR__ . '/components/db.php';
include __DIR__ . '/components/post_login_header.php';

// Načtení seznamu uživatelů
$sql = "SELECT id, name, email, role FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$users = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam uživatelů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : 'bg-light' ?>">
    <!-- Tabulka se seznamem uživatelů -->
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="mb-4 text-primary">
                    <i class="fas fa-users"></i> Seznam uživatelů
                </h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Jméno</th>
                                <th>E-mail</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['role']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Žádní uživatelé k zobrazení</td>
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
<?php
// Uzavření připojení
$conn->close();
?>