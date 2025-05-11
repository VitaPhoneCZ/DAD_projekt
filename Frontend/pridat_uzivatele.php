<?php
include "components/db.php"; // Načteme připojení k databázi
include 'components/post_login_header.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">


    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4" style="max-width: 600px; margin: 0 auto;">
            <div class="card-body p-5">
                <h2 class="text-primary mb-4">Přidání nového uživatele</h2>

                <?php if (!empty($zprava)) : ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo htmlspecialchars($zprava); ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Jméno:</label>
                        <input type="text" id="name" name="name" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select id="role" name="role" class="form-select rounded-3">
                            <option value="zak">Žák</option>
                            <option value="ucitel">Učitel</option>
                            <option value="it">IT</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill px-4">Přidat uživatele</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
