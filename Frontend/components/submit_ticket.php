<?php
// Spuštění session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kontrola přihlášení
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Načtení připojení k databázi
include __DIR__ . '/db.php';

// Získání hodnot z formuláře
$title = isset($_POST['title']) ? trim($_POST['title']) : (isset($_POST['nazev']) ? trim($_POST['nazev']) : '');
$description = isset($_POST['description']) ? trim($_POST['description']) : (isset($_POST['popis']) ? trim($_POST['popis']) : '');
$priority = isset($_POST['priority']) ? $_POST['priority'] : (isset($_POST['priorita']) ? $_POST['priorita'] : 'Nízká');
$platform = isset($_POST['platform']) ? $_POST['platform'] : (isset($_POST['platforma']) ? $_POST['platforma'] : 'Windows');

// Ověření, že pole nejsou prázdná
if (empty($title) || empty($description)) {
    $_SESSION['error'] = 'Název a Popis nesmí být prázdné.';
    header('Location: ../new_ticket.php');
    exit();
}

// Ověření platnosti hodnot pro prioritu a platformu
$platne_priority = ['Nízká', 'Střední', 'Vysoká'];
$platne_platformy = ['Windows', 'Mac', 'Linux', 'Android', 'iPhone'];

if (!in_array($priority, $platne_priority) || !in_array($platform, $platne_platformy)) {
    $_SESSION['error'] = 'Neplatná hodnota pro prioritu nebo platformu.';
    header('Location: ../new_ticket.php');
    exit();
}

// ID přihlášeného uživatele
$user_id = $_SESSION['user_id'];

// Příprava SQL dotazu (status je defaultně 'Otevřený' v databázi)
$sql = "INSERT INTO tickets (user_id, title, description, priority, platform, created_at) VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);

// Binding parametrů - pouze 5 parametrů (user_id, title, description, priority, platform)
$stmt->bind_param("issss", $user_id, $title, $description, $priority, $platform);

// Spuštění dotazu
if ($stmt->execute()) {
    $_SESSION['success'] = 'Ticket byl úspěšně vytvořen.';
    header('Location: ../tickets.php');
    exit();
} else {
    $_SESSION['error'] = 'Chyba při vytváření ticketu: ' . $stmt->error;
    header('Location: ../new_ticket.php');
    exit();
}

$stmt->close();
// Nepoužívat $conn->close() zde, protože připojení může být použito jinde
?>
