<?php
include('db.php');  // Zahrnutí souboru db.php, kde je připojení k databázi
include 'header.php';

// SQL dotaz pro načtení všech uživatelů
$query = "SELECT id, name, email, role FROM users";
$result = $conn->query($query);  // Používáme MySQLi metodu pro provedení dotazu

// Kontrola, zda dotaz vrátil nějaké výsledky
if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);  // Načteme výsledky do asociativního pole
} else {
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam uživatelů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="s/style.css">
</head>
<body style="background-color: #f8f9fa; color: #333; font-family: 'Segoe UI', sans-serif;">

    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="mb-4 text-primary">Seznam uživatelů</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Jméno</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
// Zavření připojení na konci souboru
$conn->close();
?>
