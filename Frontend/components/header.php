<?php
function renderHeader($currentPage = '') {
    echo '<header class="sticky-header">
        <div class="logo">
            <img src="photo/logo.gif" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php"' . ($currentPage == 'index' ? ' class="active"' : '') . '>Domů</a></li>
                <li><a href="#about">O nás</a></li>
                <li><a href="login.php" class="btn-login">Přihlášení</a></li>
            </ul>
        </nav>
    </header>';
}
?>
