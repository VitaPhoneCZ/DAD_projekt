<?php
session_start();
include 'db.php';
include 'header.php'; // Zahrnutí headeru a kontroly session

// Zkontroluj, jestli je uživatel přihlášen
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

$jmeno = $_SESSION['user'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id']; // Předpokládám, že máš uložené ID přihlášeného uživatele

// SQL dotaz podle role uživatele
if ($role === 'it') {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            WHERE tickets.status = 'Otevřený' 
            ORDER BY tickets.id ASC";
} else {
    $sql = "SELECT tickets.id, tickets.title, tickets.status, users.name 
            FROM tickets 
            JOIN users ON tickets.user_id = users.id 
            WHERE tickets.status = 'Otevřený' AND tickets.user_id = ?
            ORDER BY tickets.id ASC";
}

$stmt = $conn->prepare($sql);

if ($role !== 'it') {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

// SQL dotaz pro kontrolu neprečtených notifikací pro aktuálního uživatele
// Pokud je uživatel IT, kontrolujeme všechny notifikace pro všechny adminy, pokud ne, jen pro aktuálního uživatele
if ($role === 'it') {
    $sql_notifications = "SELECT COUNT(*) as unread_count FROM unread_notifications WHERE read_by IS NULL";
} else {
    $sql_notifications = "SELECT COUNT(*) as unread_count FROM unread_notifications WHERE user_id = ? AND read_by IS NULL";
}

$stmt_notifications = $conn->prepare($sql_notifications);

if ($role !== 'it') {
    $stmt_notifications->bind_param("i", $user_id);
}

$stmt_notifications->execute();
$notifications_result = $stmt_notifications->get_result();
$unread_notifications = $notifications_result->fetch_assoc();
$unread_count = $unread_notifications['unread_count'];
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavní stránka | Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="s/style.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Otevřené tickety</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Stav</th>
                    <th>Vytvořil</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        // Dotaz na nepřečtené notifikace pro konkrétní ticket a uživatele
                        $sql_ticket_notification = "SELECT COUNT(*) as unread_count 
                                    FROM unread_notifications 
                                    WHERE ticket_id = ? AND (read_by IS NULL OR read_by NOT LIKE CONCAT('%,', ?, ',%'))";
                        $stmt_ticket_notification = $conn->prepare($sql_ticket_notification);
                        $user_check = $user_id;
                        $stmt_ticket_notification->bind_param("is", $row['id'], $user_check);
                        $stmt_ticket_notification->execute();
                        $ticket_notif_result = $stmt_ticket_notification->get_result();
                        $ticket_unread = $ticket_notif_result->fetch_assoc();
                        $ticket_unread_count = $ticket_unread['unread_count'];
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td>
                                <?php
                                if ($row['status'] === 'Otevřený') {
                                    echo '<span class="badge bg-warning">Otevřený</span>';
                                } elseif ($row['status'] === 'Uzavřený') {
                                    echo '<span class="badge bg-success">Uzavřený</span>';
                                } else {
                                    echo '<span class="badge bg-secondary">Neznámý</span>';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td>
                                <a href="ticket_detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                                    Zobrazit
                                    <?php if ($ticket_unread_count > 0): ?>
                                        <span class="badge bg-danger">!</span>
                                    <?php endif; ?>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Žádné otevřené tickety</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    // Funkce pro označení notifikace jako přečtené při kliknutí na tlačítko "Zobrazit"
    if (isset($_GET['id'])) {
        $ticket_id = $_GET['id'];
        // Označ notifikaci jako přečtenou
        $sql_update = "UPDATE neprectene_notifikace 
        SET read_by = 
        CASE 
            WHEN read_by IS NULL THEN CONCAT(',', ?, ',')
            WHEN read_by NOT LIKE CONCAT('%,', ?, ',%') THEN CONCAT(read_by, ?, ',')
            ELSE read_by 
        END
        WHERE id_ticketu = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("iisi", $user_id, $user_id, $user_id, $ticket_id);

        $stmt_update->execute();
    }
    ?>

</body>

</html>