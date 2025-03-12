<?php
include "db.php"; // Načteme připojení k databázi

$zprava = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $heslo = $_POST["heslo"];
    $role = $_POST["role"] ?? "user"; // Výchozí role je "user", pokud není vybrána jiná

    // Ověření vstupů
    if (empty($name) || empty($email) || empty($heslo)) {
        $zprava = "Všechna pole jsou povinná!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $zprava = "Neplatný e-mail!";
    } elseif (strlen($heslo) < 6) {
        $zprava = "Heslo musí mít alespoň 6 znaků!";
    } elseif (!in_array($role, ['admin', 'agent', 'user'])) {
        $zprava = "Neplatná role!";
    } else {
        // Hashování hesla
        $hashovane_heslo = password_hash($heslo, PASSWORD_BCRYPT);

        // Vložení uživatele do databáze
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $hashovane_heslo, $role);

        if ($stmt->execute()) {
            $zprava = "Uživatel úspěšně přidán!";
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

        <label for="heslo">Heslo:</label>
        <input type="password" id="heslo" name="heslo" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="user">User</option>
            <option value="agent">Agent</option>
            <option value="admin">Admin</option>
        </select><br>

        <button type="submit">Přidat uživatele</button>
    </form>
</body>
</html>
