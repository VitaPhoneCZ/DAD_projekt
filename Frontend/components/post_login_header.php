<?php
// Spuštění session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kontrola přihlášení uživatele
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Nastavení údajů uživatele
$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$profilovy_obrazek = match ($role) {
    'it' => 'photo/it-pfp.jpg',
    'ucitel' => 'photo/ucitel.jpg',
    'zak' => 'photo/zak.jpg',
    default => 'photo/default.png'
};
?>

<header>
    <!-- Navigační menu pro přihlášené uživatele -->
    <div class="logo">
        <img src="photo/logo.gif" alt="Logo">
    </div>
    <button class="nav-toggle" aria-label="Přepnout navigaci" aria-expanded="false">☰</button>
    <div class="nav-container">
        <nav role="navigation">
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
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                        <img src="<?= htmlspecialchars($profilovy_obrazek) ?>" alt="Profilový obrázek" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; vertical-align: middle; margin-right: 8px;">
                        <?= htmlspecialchars($jmeno) ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="muj-ucet.php">Můj účet</a></li>
                        <li><a href="components/logout.php">Odhlásit se</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>

<script>
    // Přepínání mobilní navigace
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('header nav ul');
    navToggle.addEventListener('click', () => {
        const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', !isExpanded);
        navMenu.classList.toggle('active');
    });

    // Přepínání dropdown menu
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const parent = toggle.parentElement;
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', !isExpanded);
            parent.classList.toggle('active');
        });
    });
</script>