<?php
// Spuštění session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Načtení potřebných souborů
include __DIR__ . '/components/db.php';
include __DIR__ . '/components/post_login_header.php';

// Kontrola přihlášení uživatele
if (!isset($_SESSION['email'])) {
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

// Získání údajů uživatele
$jmeno = $_SESSION['user'] ?? 'Neznámý uživatel';
$email = $_SESSION['email'] ?? 'Neznámý email';
$role = $_SESSION['role'] ?? 'Neznámá role';

// Výběr profilového obrázku podle role
$profilovy_obrazek = match ($role) {
    'it' => 'photo/it-pfp.jpg',
    'ucitel' => 'photo/ucitel.jpg',
    'zak' => 'photo/zak.jpg',
    default => 'photo/default.png'
};
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Můj profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : 'bg-light' ?>">
    <!-- Profil uživatele -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <img src="<?= htmlspecialchars($profilovy_obrazek); ?>"
                                 alt="Profilový obrázek"
                                 class="rounded-circle border border-3"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <h3 class="fw-semibold"><?= htmlspecialchars($jmeno); ?></h3>
                        <p class="text-muted mb-1"><?= htmlspecialchars($email); ?></p>
                        <p class="text-secondary small">Role: <strong><?= htmlspecialchars($role); ?></strong></p>
                        <div class="mt-4">
                            <a href="components/logout.php" class="btn btn-outline-danger rounded-pill px-4">
                                <i class="fas fa-sign-out-alt"></i> Odhlásit se
                            </a>
                            <div class="form-check form-switch mt-4 d-flex justify-content-center align-items-center gap-2">
                                <input class="form-check-input" type="checkbox" id="darkModeSwitch" <?= ($_SESSION['dark_mode'] ?? 0) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="darkModeSwitch">Dark mode</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('darkModeSwitch').addEventListener('change', function() {
            const enabled = this.checked ? 1 : 0;
            fetch('components/toggle_dark_mode.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'dark_mode=' + enabled
            }).then(res => res.text()).then(data => {
                location.reload();
            });
        });
    </script>
</body>
</html>