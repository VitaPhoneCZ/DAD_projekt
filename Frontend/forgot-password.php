<?php
// Načtení potřebných souborů
include __DIR__ . '/components/db.php';
include __DIR__ . '/components/header.php';
include __DIR__ . '/components/footer.php';

// Zpracování POST požadavku pro reset hesla
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $code = $_POST['code'] ?? null;
    $newPassword = $_POST['new_password'] ?? null;

    if ($email && $code && $newPassword) {
        // Ověření resetovacího kódu
        $stmt = $conn->prepare("SELECT code FROM password_reset_codes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $storedCode = $result->fetch_assoc();

        if ($storedCode && $storedCode['code'] === $code) {
            // Aktualizace hesla
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $email);
            $stmt->execute();

            // Smazání resetovacího kódu
            $stmt = $conn->prepare("DELETE FROM password_reset_codes WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            echo "Heslo bylo úspěšně resetováno.";
        } else {
            echo "Neplatný kód nebo e-mail.";
        }
    } else {
        echo "Vyplňte všechny povinné údaje.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Založení/Obnovení hesla</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php renderHeader('forgot-password'); ?>
    
    <!-- Formulář pro reset hesla -->
    <main class="auth-container">
        <form class="auth-form" method="POST">
            <h2>Založení/Obnovení hesla</h2>
            <label for="email"><i class="fas fa-envelope"></i> E-mail</label>
            <input type="email" id="email" name="email" placeholder="Zadejte váš e-mail" required>
            
            <label for="code"><i class="fas fa-key"></i> Resetovací kód</label>
            <input type="text" id="code" name="code" placeholder="Zadejte resetovací kód">
            
            <label for="new_password"><i class="fas fa-lock"></i> Nové heslo</label>
            <input type="password" id="new_password" name="new_password" placeholder="Zadejte nové heslo">
            
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Nastavit heslo
            </button>
            <p><a href="login.php">Zpět na přihlášení</a></p>
        </form>
    </main>

    <?php renderFooter(); ?>
</body>
</html>