<?php
// Spuštění session
session_start();

// Přesměrování přihlášeného uživatele
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

// Načtení potřebných souborů
include __DIR__ . '/components/login_process.php';
include __DIR__ . '/components/header.php';
include __DIR__ . '/components/footer.php';
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/auth.css">
</head>
<body>
    <?php renderHeader('login'); ?>
    <!-- Formulář pro přihlášení -->
    <main class="auth-container">
        <form class="auth-form" action="login.php" method="POST">
            <h2>Přihlášení</h2>

            <?php if (isset($error_message)): ?>
                <p class="error"><?= htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Zadejte e-mail" required>

            <label for="password">Heslo</label>
            <input type="password" id="password" name="password" placeholder="Zadejte heslo" required>

            <button type="submit" class="btn">Přihlásit se</button>
            <p><a href="forgot-password.php">Zapomněli jste heslo, nebo jste tu noví?</a></p>
        </form>
    </main>
    <?php renderFooter(); ?>
</body>
</html>