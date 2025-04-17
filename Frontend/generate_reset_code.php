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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="s/style.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">

    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 500px;">
            <div class="card-body p-5">
                <h2 class="mb-4 text-primary text-center">Generování kódu pro reset hesla</h2>
                <form method="POST" action="generate_reset_code.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail uživatele:</label>
                        <input type="email" class="form-control rounded-pill px-3 py-2" id="email" name="email" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill py-2">Generovat kód</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

