<?php
// Spuštění session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Načtení připojení k databázi
include __DIR__ . '/../db.php';

// Zpracování přihlašovacího formuláře
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Ověření vstupů
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Vyplňte e-mail a heslo.';
            header('Location: login.php');
            exit();
        }

        // Ověření uživatele v databázi
        $stmt = $conn->prepare("SELECT id, name, email, role, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Ověření hesla
            if (password_verify($password, $user['password'])) {
                // Nastavení session
                $_SESSION['user'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];

                // Přesměrování na dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Neplatné heslo.';
            }
        } else {
            $_SESSION['error'] = 'Uživatel s tímto e-mailem neexistuje.';
        }

        // Přesměrování zpět na přihlášení s chybou
        header('Location: login.php');
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = 'Chyba při přihlášení: ' . $e->getMessage();
        header('Location: login.php');
        exit();
    }
}

// Uzavření připojení
$conn->close();
?>