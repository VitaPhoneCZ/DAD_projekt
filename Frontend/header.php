<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$profilovy_obrazek = ($role === 'it') ? 'photo/it-pfp.jpg' : (($role === 'ucitel') ? 'photo/ucitel.jpg' : (($role === 'zak') ? 'photo/zak.jpg' : 'photo/default.png'));
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Hlavní stránka</title>
    <link rel="stylesheet" href="s/style.css">
</head>

<body>

    <header class="sticky-header">
        <div class="logo">
            <img src="photo/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Domů</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="new_ticket.php">Nový ticket</a></li>
                <li><a href="tickets.php">Seznam ticketů</a></li>

                <?php if ($role === 'it'): ?>
                    <li><a href="pridat_uzivatele.php">Přidání uživatele</a></li>
                    <li><a href="generate_reset_code.php">Generace reset kódu</a></li>
                    <li><a href="users.php">Seznam uživatelů</a></li>
                <?php endif; ?>

                <li><a href="logout.php">Odhlásit se</a></li>
            </ul>
        </nav>

        <div class="user-box" style="display: flex; align-items: center; gap: 10px">
            <nav>
                <ul>
                    <li><a href="muj-ucet.php">
                            <img src="<?= htmlspecialchars($profilovy_obrazek) ?>" alt="Profilový obrázek" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </a></li>
                    <li><a href="muj-ucet.php"><?= htmlspecialchars($jmeno) ?></a></li>
                </ul>
            </nav>


        </div>
    </header>

</body>

</html>