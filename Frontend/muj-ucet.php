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
    <title>Můj profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="s/style.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center p-5">

                    <div class="mb-4">
                        <img src="<?php echo htmlspecialchars($profilovy_obrazek); ?>"
                             alt="Profilový obrázek"
                             class="rounded-circle border border-3"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>

                    <h3 class="fw-semibold"><?php echo htmlspecialchars($jmeno); ?></h3>
                    <p class="text-muted mb-1"><?php echo htmlspecialchars($email); ?></p>
                    <p class="text-secondary small">Role: <strong><?php echo htmlspecialchars($role); ?></strong></p>

                    <div class="mt-4">
                        <a href="logout.php" class="btn btn-outline-danger rounded-pill px-4">Odhlásit se</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

