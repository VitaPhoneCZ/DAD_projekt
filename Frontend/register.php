<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="register_process.php" method="post">
        <h2>Registrace</h2>
        <input type="text" name="name" placeholder="Jméno" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="password" placeholder="Heslo" required>
        <button type="submit">Registrovat se</button>
    </form>
    <p>Máte účet? <a href="login.php">Přihlaste se</a></p>
</body>
</html>