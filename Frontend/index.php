<?php include __DIR__ . '/components/header.php'; ?>
<?php include __DIR__ . '/components/footer.php'; ?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickovací Web</title>
    <link rel="stylesheet" href="s/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="scripts/script.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">
    <?php renderHeader('index'); ?>
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

        <section class="bg-white dark:bg-gray-700">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6 text-center">
                <div class="max-w-screen-md mb-8 lg:mb-16 mx-auto">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Funkcionality</h2>
                </div>
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                    <div class="text-center">
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900 mx-auto">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="#000000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Vytváření ticketů</h3>
                        <p class="text-gray-500 dark:text-gray-400">Uživatelé mohou zadávat nové tickety s popisem problému.</p>
                    </div>
                    <div class="text-center">
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900 mx-auto">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="#000000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Správa ticketů</h3>
                        <p class="text-gray-500 dark:text-gray-400">Možnost přiřazování ticketů a změny stavu (otevřený, v řešení, uzavřený).</p>
                    </div>
                    <div class="text-center">
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900 mx-auto">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="#000000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Notifikace</h3>
                        <p class="text-gray-500 dark:text-gray-400">Upozornění při změně stavu nebo přiřazení ticketu.</p>
                    </div>
                    <div class="text-center">
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900 mx-auto">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="#000000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Historie a sledování</h3>
                        <p class="text-gray-500 dark:text-gray-400">Uchování změn a průběhu řešení ticketu.</p>
                    </div>
                    <div class="text-center">
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900 mx-auto">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="#000000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Vyhledávání a filtrování</h3>
                        <p class="text-gray-500 dark:text-gray-400">Možnost filtrovat tickety podle různých kritérií.</p>
                    </div>
                    <div class="text-center">
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900 mx-auto">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="#000000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Autentizace přes e-mail</h3>
                        <p class="text-gray-500 dark:text-gray-400">Uživatelé se přihlásí pomocí svého e-mailu, což umožňuje bezpečný přístup.</p>
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
