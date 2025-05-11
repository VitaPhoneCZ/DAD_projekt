<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Spustí session pouze pokud není aktivní
}


// Debugging - vypíše všechny session proměnné
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Zkontroluje, jestli je user_id nastaven
if (!isset($_SESSION['user_id'])) {
    die('Chyba: Uživatel není přihlášen. <br> Zkontroluj, jestli je user_id nastaven ve session.');
}

// Pokračuje dál, pokud je přihlášen
include 'db.php'; 
?>

<?php


if (!isset($_SESSION['user_id'])) {
    die('Uživatel není přihlášen.');
}

include 'db.php'; // Připojení k databázi

// Získání hodnot z formuláře
$nazev = isset($_POST['nazev']) ? trim($_POST['nazev']) : '';
$popis = isset($_POST['popis']) ? trim($_POST['popis']) : '';
$priorita = isset($_POST['priorita']) ? $_POST['priorita'] : 'Nízká';
$platforma = isset($_POST['platforma']) ? $_POST['platforma'] : 'Windows';

// Ověření, že pole nejsou prázdná
if (empty($nazev) || empty($popis)) {
    die('Chyba: Název a Popis nesmí být prázdné.');
}

// Ověření platnosti hodnot pro prioritu a platformu
$platne_priority = ['Nízká', 'Střední', 'Vysoká'];
$platne_platformy = ['Windows', 'Mac', 'Linux', 'Android', 'iPhone'];

if (!in_array($priorita, $platne_priority) || !in_array($platforma, $platne_platformy)) {
    die('Chyba: Neplatná hodnota pro prioritu nebo platformu.');
}

// Výchozí hodnoty
$stav = 'Otevřený'; // Vždy se vytvoří jako "Otevřený"
$user_id = $_SESSION['user_id']; // ID přihlášeného uživatele

// Příprava SQL dotazu
$sql = "INSERT INTO tickets (user_id, title, description, priority, platform, created_at) VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);

// Binding parametrů
$stmt->bind_param("isssss", $user_id, $nazev, $popis, $stav, $priorita, $platforma);

// Spuštění dotazu
if ($stmt->execute()) {
    echo "Ticket byl úspěšně vytvořen.";
    header('Location: tickets.php'); // Přesměrování na seznam ticketů
    exit();
} else {
    echo "Chyba při vytváření ticketu: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>