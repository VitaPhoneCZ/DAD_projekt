<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Zajištění, že session je aktivní
}

include 'db.php';
include 'header.php';

// Získání údajů ze session
$jmeno = isset($_SESSION['user']) ? $_SESSION['user'] : "Neznámý uživatel";
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "Neznámý email";
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "Neznámá role";

// Nastavení profilového obrázku podle role
$profilovy_obrazek = ($role === 'it') ? 'photo/it-pfp.jpg' : (($role === 'ucitel') ? 'photo/ucitel.jpg' : (($role === 'zak') ? 'photo/zak.jpg' : 'photo/default.png'));
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Můj účet</title>
    <link rel="stylesheet" href="s/style.css">
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            background-color: gray;
            border-radius: 50%;
            margin: 10px auto;
            background-image: url(<?php echo htmlspecialchars($profilovy_obrazek); ?>);
            background-size: cover;
            background-position: center;
        }
        .info {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
        }
        .logout-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Můj účet</h2>
    <div class="profile-pic"></div> <!-- Profilový obrázek -->
    <p><strong>Jméno:</strong> <?php echo htmlspecialchars($jmeno); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>
    <a href="logout.php" class="logout-button">Odhlásit se</a>
</div>

</body>
</html>
