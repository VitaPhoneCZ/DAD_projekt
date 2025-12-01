<?php
session_start();
// Načtení potřebných souborů
include __DIR__ . '/components/header.php';
include __DIR__ . '/components/footer.php';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickovací Web</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="scripts/script.js" defer></script>
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">
    <?php renderHeader('index'); ?>
    <!-- Hlavní obsah stránky -->
    <main>
        <section class="hero" id="hero-background">
            <div class="hero-text">
                <h1 class="text-4xl">Send&Solve</h1>
                <p>Moderní ticketovací nástroj pro snadné řešení problémů</p>
                <a href="login.php" class="btn-main">
                    Přihlášení
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/three@0.134.0/build/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanta/dist/vanta.globe.min.js"></script>
        <script>
            VANTA.GLOBE({
                el: "#hero-background",
                mouseControls: true,
                touchControls: true,
                gyroControls: false,
                minHeight: 200.00,
                minWidth: 200.00,
                scale: 1.00,
                scaleMobile: 1.00,
                color: 0xb2988,
                color2: 0x8b88ff,
                backgroundColor: 0xc5c5c5
            })
        </script>

        <section class="about" id="about">
            <div class="o-aplikaci">
                <h2 class="text-4xl">O Aplikaci</h2>
                <p>Send&Solve je ticketovací nástroj pro efektivní správu IT požadavků.</p>
                <p>Zaměstnanci mohou jednoduše nahlásit problém a IT tým se o něj postará. Tento nástroj bude obsahovat dvě hlavní části: frontend vyvinutý v PHP a backend v Node.js s Express.js.</p>
            </div>
        </section>

        <section class="features-section">
            <div class="container" style="padding: 4rem 1rem;">
                <div style="max-width: 800px; margin: 0 auto 3rem; text-align: center;">
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">Funkcionality</h2>
                    <p style="font-size: 1.125rem;">Vše co potřebujete pro efektivní správu ticketů</p>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto;">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h3>Vytváření ticketů</h3>
                        <p>Uživatelé mohou zadávat nové tickety s popisem problému.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Správa ticketů</h3>
                        <p>Možnost přiřazování ticketů a změny stavu (otevřený, v řešení, uzavřený).</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3>Notifikace</h3>
                        <p>Upozornění při změně stavu nebo přiřazení ticketu.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3>Historie a sledování</h3>
                        <p>Uchování změn a průběhu řešení ticketu.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Vyhledávání a filtrování</h3>
                        <p>Možnost filtrovat tickety podle různých kritérií.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Autentizace přes e-mail</h3>
                        <p>Uživatelé se přihlásí pomocí svého e-mailu, což umožňuje bezpečný přístup.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="reviews">
            <h2>Recenze</h2>
            <div class="reviews-container">
                <div class="review-card">
                    <img src="photo/user.png" alt="Profilový obrázek">
                    <p>"Jednoduché použití a skvělá podpora!"</p>
                    <h4>- Petr M.</h4>
                </div>
                <div class="review-card">
                    <img src="photo/user.png" alt="Profilový obrázek">
                    <p>"Rychlé řešení problémů a skvělý tým."</p>
                    <h4>- Jana K.</h4>
                </div>
                <div class="review-card">
                    <img src="photo/user.png" alt="Profilový obrázek">
                    <p>"Moderní design a snadné používání."</p>
                    <h4>- Tomáš L.</h4>
                </div>
            </div>
        </section>

        <section class="gallery">
            <h2>Galerie</h2>
            <div class="gallery-container">
                <img src="photo/image1.png" alt="Obrázek 1" onclick="openLightbox(this)">
                <img src="photo/image2.png" alt="Obrázek 2" onclick="openLightbox(this)">
                <img src="photo/image3.png" alt="Obrázek 3" onclick="openLightbox(this)">
            </div>

            <!-- Lightbox (popup obrázek) -->
            <div id="lightbox" class="lightbox" onclick="closeLightbox()">
                <img id="lightbox-img">
            </div>
        </section>

        <section class="about" id="about">
            <div class="o-aplikaci">
                <h2>GitHub projektu</h2>
                <p><a href="https://github.com/VitaPhoneCZ/DAD_projekt" target="_blank">👉 https://github.com/VitaPhoneCZ/DAD_projekt</a></p>
            </div>
        </section>
    </main>
    <?php renderFooter(); ?>
</body>
</html>