<?php
// Načtení potřebných souborů
include __DIR__ . '/components/db.php';
include __DIR__ . '/components/post_login_header.php';

// Zpracování POST požadavku pro generování kódu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if ($email) {
        // Ověření existence uživatele
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Generování a uložení 6místného kódu
            $code = rand(100000, 999999);
            $stmt = $conn->prepare("REPLACE INTO password_reset_codes (email, code) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $code);
            $stmt->execute();

            echo "Kód pro reset hesla byl vygenerován: " . $code;
        } else {
            echo "Uživatel s tímto e-mailem neexistuje.";
        }
    } else {
        echo "Vyplňte e-mailovou adresu.";
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
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">
    <!-- Formulář pro generování resetovacího kódu -->
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 500px;">
            <div class="card-body p-5">
                <h2 class="mb-4 text-primary text-center">
                    <i class="fas fa-key"></i> Generování kódu pro reset hesla
                </h2>
                <form method="POST" action="generate_reset_code.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail uživatele:</label>
                        <input type="email" class="form-control rounded-pill px-3 py-2" id="email" name="email" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill py-2">
                            <i class="fas fa-magic"></i> Generovat kód
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>