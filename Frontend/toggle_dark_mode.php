<?php
session_start();

if (isset($_SESSION['email']) && isset($_POST['dark_mode'])) {
    // Připojení k databázi
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "dad_db";
    
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Zkontrolujeme připojení
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Získáme hodnotu dark_mode z požadavku
    $dark_mode = $_POST['dark_mode'];
    $email = $_SESSION['email'];

    // Příprava a vykonání SQL dotazu pro aktualizaci hodnoty dark_mode v databázi
    $stmt = $conn->prepare("UPDATE users SET dark_mode = ? WHERE email = ?");
    $stmt->bind_param("is", $dark_mode, $email);  // Parametr pro dark_mode (tinyint) a email (varchar)
    
    // Vykonáme dotaz
    if ($stmt->execute()) {
        echo "Dark mode nastaveno.";
    } else {
        echo "Došlo k chybě při ukládání změny.";
    }

    // Uzavřeme připojení
    $stmt->close();
    $conn->close();
} else {
    echo "Není nastavený email nebo dark_mode.";
}
?>
