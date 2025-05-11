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

<header>
    <div class="logo">
        <img src="photo/logo.gif" alt="Logo">
    </div>
    <button class="nav-toggle" aria-label="Toggle navigation">☰</button>
    <div class="nav-container">
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
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
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
    document.querySelector('.nav-toggle').addEventListener('click', () => {
        document.querySelector('header nav ul').classList.toggle('active');
    });

    // Mobile dropdown toggle
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default link behavior
            const parent = toggle.parentElement; // Get parent <li class="dropdown">
            parent.classList.toggle('active');
        });
    });
</script>