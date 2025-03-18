<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Zavolá session_start() pouze pokud ještě není aktivní
}
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>

<header>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="new_ticket.php">Nový ticket</a>
        <a href="tickets.php">Seznam ticketů</a>
        <a href="pridat_uzivatele.php">Přidání uživatele</a>
        <a href="generate_reset_code.php">Generace reset kódu</a>
        <a href="users.php">Seznam uživatelů</a>
        <a href="logout.php">Odhlásit se</a>
    </nav>
</header>