<?php
session_start();
include 'db.php';

// Zkontroluj, jestli je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    echo "Uživatel není přihlášen.";
    exit();
}

// Zpracování formuláře pro vytvoření ticketu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získání hodnot z formuláře
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $platform = $_POST['platform'];

    // Ověření, že hodnoty nejsou prázdné
    if (empty($title) || empty($description) || empty($priority) || empty($platform)) {
        echo "Všechna pole musí být vyplněná.";
        exit();
    }

    // Příprava SQL dotazu pro vložení ticketu
    $sql = "INSERT INTO tickets (user_id, title, description, priority, platform, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    $user_id = $_SESSION['user_id'];
    $stmt->bind_param("issss", $user_id, $title, $description, $priority, $platform);

    if ($stmt->execute()) {
        // Získání ID nového ticketu
        $ticket_id = $stmt->insert_id;
    
        // Vložení do tabulky unread_notifications
        $notification_sql = "INSERT INTO unread_notifications (ticket_id, user_id, notification_count, read_by) VALUES (?, ?, ?, ?)";
        $notification_stmt = $conn->prepare($notification_sql);
    
        $notification_count = 1;
        $read_by = strval($user_id); // autor bude rovnou uveden jako že už si to přečetl
    
        $notification_stmt->bind_param("iiis", $ticket_id, $user_id, $notification_count, $read_by);
        $notification_stmt->execute();
        $notification_stmt->close();
    
        echo "Ticket byl úspěšně vytvořen!";
    }
    else {
        echo "Došlo k chybě při vytváření ticketu: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vytvořit nový ticket</title>
    <link rel="stylesheet" href="s/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <h2>Vytvořit nový ticket</h2>
    <form action="new_ticket.php" method="POST">
        <label for="title">Název ticketu</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Popis ticketu</label>
        <textarea id="description" name="description" required></textarea>

        <label for="priority">Priorita</label>
        <select id="priority" name="priority" required>
            <option value="Nízká">Nízká</option>
            <option value="Střední">Střední</option>
            <option value="Vysoká">Vysoká</option>
        </select>

        <label for="platform">Platforma</label>
        <select id="platform" name="platform" required>
            <option value="Windows">Windows</option>
            <option value="Mac">Mac</option>
            <option value="Linux">Linux</option>
            <option value="Android">Android</option>
            <option value="iPhone">iPhone</option>
        </select>

        <button type="submit">Vytvořit ticket</button>
    </form>
</div>

</body>
</html>
