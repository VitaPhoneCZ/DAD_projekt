<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

// Nastavení jména a role uživatele
$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];

// Nastavení profilového obrázku
$profilovy_obrazek = ($role === 'it') ? 'photo/it-pfp.jpg' : (($role === 'ucitel') ? 'photo/ucitel.jpg' : (($role === 'zak') ? 'photo/zak.jpg' : 'photo/default.png'));

?>

<header style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #333; color: white;">
    <nav>
        <a href="index.php" style="color: white; text-decoration: none; margin-right: 15px;">Domů</a>
        <a href="dashboard.php" style="color: white; text-decoration: none; margin-right: 15px;">Dashboard</a>
        <a href="new_ticket.php" style="color: white; text-decoration: none; margin-right: 15px;">Nový ticket</a>
        <a href="tickets.php" style="color: white; text-decoration: none; margin-right: 15px;">Seznam ticketů</a>
        <a href="pridat_uzivatele.php" style="color: white; text-decoration: none; margin-right: 15px;">Přidání uživatele</a>
        <a href="generate_reset_code.php" style="color: white; text-decoration: none; margin-right: 15px;">Generace reset kódu</a>
        <a href="users.php" style="color: white; text-decoration: none; margin-right: 15px;">Seznam uživatelů</a>
        <a href="logout.php" style="color: white; text-decoration: none; margin-right: 15px;">Odhlásit se</a>
    </nav>
    
    <!-- Zobrazení jména a profilového obrázku -->
    <div style="display: flex; align-items: center;">
    <a href="muj-ucet.php"><img src="<?= htmlspecialchars($profilovy_obrazek) ?>" alt="Profilový obrázek" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;"></a>
        <a href="muj-ucet.php" style="color: white; text-decoration: none; font-weight: bold;"><?php echo htmlspecialchars($jmeno); ?></a>
    </div>
</header>
