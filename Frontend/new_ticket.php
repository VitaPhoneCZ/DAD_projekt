<?php
// Spuštění session
session_start();

// Načtení potřebných souborů
include __DIR__ . '/components/db.php';
include __DIR__ . '/components/post_login_header.php';

// Kontrola přihlášení uživatele
if (!isset($_SESSION['user_id'])) {
    echo "Uživatel není přihlášen.";
    exit();
}

// Zpracování formuláře pro vytvoření ticketu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $priority = $_POST['priority'] ?? '';
    $platform = $_POST['platform'] ?? '';

    // Kontrola vyplnění všech polí
    if (empty($title) || empty($description) || empty($priority) || empty($platform)) {
        echo "Vyplňte všechna povinná pole.";
        exit();
    }

    // Vložení ticketu do databáze
    $sql = "INSERT INTO tickets (user_id, title, description, priority, platform, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $user_id = $_SESSION['user_id'];
    $stmt->bind_param("issss", $user_id, $title, $description, $priority, $platform);

    if ($stmt->execute()) {
        echo "Ticket byl úspěšně vytvořen.";
    } else {
        echo "Chyba při vytváření ticketu: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vytvořit nový ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">
    <!-- Formulář pro vytvoření ticketu -->
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 600px;">
            <div class="card-body p-5">
                <h2 class="mb-4 text-primary text-center">Vytvořit nový ticket</h2>
                <form action="new_ticket.php" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Název ticketu</label>
                        <input type="text" id="title" name="title" class="form-control rounded-pill px-3 py-2" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Popis ticketu</label>
                        <textarea id="description" name="description" class="form-control rounded-4 px-3 py-2" rows="5" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priorita</label>
                        <select id="priority" name="priority" class="form-select rounded-pill px-3 py-2" required>
                            <option value="Nízká" <?= (isset($_POST['priority']) && $_POST['priority'] === 'Nízká') ? 'selected' : '' ?>>Nízká</option>
                            <option value="Střední" <?= (isset($_POST['priority']) && $_POST['priority'] === 'Střední') ? 'selected' : '' ?>>Střední</option>
                            <option value="Vysoká" <?= (isset($_POST['priority']) && $_POST['priority'] === 'Vysoká') ? 'selected' : '' ?>>Vysoká</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="platform" class="form-label">Platforma</label>
                        <select id="platform" name="platform" class="form-select rounded-pill px-3 py-2" required>
                            <option value="Windows" <?= (isset($_POST['platform']) && $_POST['platform'] === 'Windows') ? 'selected' : '' ?>>Windows</option>
                            <option value="Mac" <?= (isset($_POST['platform']) && $_POST['platform'] === 'Mac') ? 'selected' : '' ?>>Mac</option>
                            <option value="Linux" <?= (isset($_POST['platform']) && $_POST['platform'] === 'Linux') ? 'selected' : '' ?>>Linux</option>
                            <option value="Android" <?= (isset($_POST['platform']) && $_POST['platform'] === 'Android') ? 'selected' : '' ?>>Android</option>
                            <option value="iPhone" <?= (isset($_POST['platform']) && $_POST['platform'] === 'iPhone') ? 'selected' : '' ?>>iPhone</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Vytvořit ticket</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>