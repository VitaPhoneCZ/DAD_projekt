<?php
include 'db.php';
include __DIR__ . '/components/header.php'; 
include __DIR__ . '/components/footer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $code = $_POST['code'] ?? null;
    $newPassword = $_POST['new_password'] ?? null;

    if ($code && $newPassword) {
        // Ověření kódu v tabulce password_reset_codes
        $stmt = $conn->prepare("SELECT code FROM password_reset_codes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $storedCode = $result->fetch_assoc();

        if ($storedCode && $storedCode['code'] == $code) {
            // Kód je správný, nastavíme heslo
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
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Založení/Obnovení hesla</title>
    <link rel="stylesheet" href="s/style.css">
    <link rel="stylesheet" href="s/auth.css">
</head>
<body>
    <?php renderHeader('forgot-password'); ?>
    
    <main class="auth-container">
        <form class="auth-form" method="POST">
            <h2>Založení/Obnovení hesla</h2>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Zadejte váš e-mail" required>
            
            <label for="code">Resetovací kód</label>
            <input type="text" id="code" name="code" placeholder="Zadejte resetovací kód">
            
            <label for="new_password">Nové heslo</label>
            <input type="password" id="new_password" name="new_password" placeholder="Zadejte nové heslo">
            
            <button type="submit" class="btn">Nastavit heslo</button>
            <p><a href="login.php">Zpět na přihlášení</a></p>
        </form>
    </main>

    <?php renderFooter(); ?>
</body>
</html>
