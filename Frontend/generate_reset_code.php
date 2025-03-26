<?php
// Zahrnutí připojení k databázi
include 'db.php';
include 'header.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Získání emailu z formuláře
    $email = $_POST['email'];

    // Ověření, zda uživatel existuje v databázi
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generování 6-místného kódu
        $code = rand(100000, 999999);

        // Uložení kódu do databáze
        $stmt = $conn->prepare("REPLACE INTO password_reset_codes (email, code) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $code);
        $stmt->execute();

        // Oznámení o úspěchu
        echo "Kód pro reset hesla byl vygenerován a uložen. Poskytněte tento kód uživateli: " . $code;
    } else {
        echo "Uživatel s tímto e-mailem neexistuje.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generování kódu pro reset hesla</title>
    <link rel="stylesheet" href="s/style.css">
</head>
<body>
    <h2>Generování kódu pro reset hesla</h2>
    <form method="POST" action="generate_reset_code.php">
        <label for="email">E-mail uživatele:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Generovat kód</button>
    </form>
</body>
</html>
