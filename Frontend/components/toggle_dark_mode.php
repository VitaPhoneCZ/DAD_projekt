<?php
// Spuštění session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kontrola přihlášení a POST parametrů
if (isset($_SESSION['email']) && isset($_POST['dark_mode'])) {
    // Načtení připojení k databázi
    include __DIR__ . '/db.php';

    // Získání hodnoty dark_mode z požadavku
    $dark_mode = (int)$_POST['dark_mode']; // Zajištění, že je to integer (0 nebo 1)
    $email = $_SESSION['email'];

    // Příprava a vykonání SQL dotazu pro aktualizaci hodnoty dark_mode v databázi
    $stmt = $conn->prepare("UPDATE users SET dark_mode = ? WHERE email = ?");
    $stmt->bind_param("is", $dark_mode, $email);
    
    // Vykonáme dotaz
    if ($stmt->execute()) {
        // Aktualizace session
        $_SESSION['dark_mode'] = $dark_mode;
        echo "Dark mode nastaveno.";
    } else {
        http_response_code(500);
        echo "Došlo k chybě při ukládání změny.";
    }

    $stmt->close();
    // Nepoužívat $conn->close() zde, protože připojení může být použito jinde
} else {
    http_response_code(400);
    echo "Není nastavený email nebo dark_mode.";
}
?>
