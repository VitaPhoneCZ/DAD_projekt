<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Zajištění, že session je aktivní
}

include 'components/db.php';
include 'components/post_login_header.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Získáme email z session, abychom našli uživatele v databázi
$email = $_SESSION['email'];

// Načteme hodnotu dark_mode pro tohoto uživatele z databáze
$stmt = $conn->prepare("SELECT dark_mode FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $_SESSION['dark_mode'] = $row['dark_mode'];  // Uložíme hodnotu do session
}

// Získání údajů ze session
$jmeno = isset($_SESSION['user']) ? $_SESSION['user'] : "Neznámý uživatel";
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "Neznámý email";
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "Neznámá role";

// Nastavení profilového obrázku podle role
$profilovy_obrazek = ($role === 'it') ? 'photo/it-pfp.jpg' : (($role === 'ucitel') ? 'photo/ucitel.jpg' : (($role === 'zak') ? 'photo/zak.jpg' : 'photo/default.png'));
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Můj profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>


<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : 'bg-light' ?>">

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
                            <a href="logout.php" class="btn btn-outline-danger rounded-pill px-4">Odhlásit se</a>
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