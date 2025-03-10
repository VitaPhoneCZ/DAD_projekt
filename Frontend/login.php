<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="login_process.php" method="post">
        <h2>Přihlášení</h2>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="password" placeholder="Heslo" required>
        <button type="submit">Přihlásit se</button>
    </form>
    <p>Nemáte účet? <a href="register.php">Registrujte se</a></p>
</body>
</html>