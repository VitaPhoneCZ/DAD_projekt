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
    <link rel="stylesheet" href="s/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h1>Seznam uživatelů</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Jméno</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>

<?php
// Zavření připojení na konci souboru
$conn->close();
?>
