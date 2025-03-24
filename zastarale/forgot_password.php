<?php
// Zahrnutí připojení k databázi
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Získání hodnot z formuláře
    $email = $_POST['email'];
    $code = $_POST['code'];
    $newPassword = $_POST['new_password'];

    // Ověření kódu v tabulce password_reset_codes
    $stmt = $conn->prepare("SELECT code FROM password_reset_codes WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $storedCode = $result->fetch_assoc();

    if ($storedCode && $storedCode['code'] == $code) {
        // Kód je správný, tedy pokračujeme v resetování hesla
        // Hashování nového hesla
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Aktualizace hesla uživatele v tabulce users
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        $stmt->execute();

        // Smazání resetovacího kódu z tabulky password_reset_codes
        $stmt = $conn->prepare("DELETE FROM password_reset_codes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        echo "Heslo bylo úspěšně resetováno.";
    } else {
        echo "Neplatný kód nebo e-mail.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset hesla</title>
</head>
<body>
    <h2>Resetování hesla</h2>
    <form method="POST" action="forgot_password.php">
        <label for="email">E-mail uživatele:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="code">Resetovací kód:</label>
        <input type="text" id="code" name="code" required>
        <br>
        <label for="new_password">Nové heslo:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <button type="submit">Resetovat heslo</button>
    </form>
</body>
</html>
