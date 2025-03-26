<?php
include "db.php"; // Načteme připojení k databázi
include 'header.php';

$zprava = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $role = $_POST["role"] ?? "zak"; // Výchozí role je "zak", pokud není vybrána jiná

    // Ověření vstupů
    if (empty($name) || empty($email)) {
        $zprava = "Všechna pole jsou povinná!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $zprava = "Neplatný e-mail!";
    } elseif (!in_array($role, ['ucitel', 'zak', 'it'])) {
        $zprava = "Neplatná role!";
    } else {
        // Generování 6-místného resetovacího kódu
        $reset_code = rand(100000, 999999);

        // Vložení uživatele do databáze (bez hesla)
        $sql = "INSERT INTO users (name, email, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $role);

        if ($stmt->execute()) {
            // Uložení resetovacího kódu do databáze
            $stmt = $conn->prepare("REPLACE INTO password_reset_codes (email, code) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $reset_code);
            $stmt->execute();
            
            $zprava = "Uživatel úspěšně přidán! Resetovací kód: " . $reset_code;
        } else {
            $zprava = "Chyba: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat uživatele</title>
    <link rel="stylesheet" href="s/style.css">
</head>
<body>
    <h2>Přidání nového uživatele</h2>
    
    <?php if (!empty($zprava)) : ?>
        <p><?php echo htmlspecialchars($zprava); ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="name">Jméno:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="zak">Žák</option>
            <option value="ucitel">Učitel</option>
            <option value="it">IT</option>
        </select><br>

        <button type="submit">Přidat uživatele</button>
    </form>
</body>
</html>