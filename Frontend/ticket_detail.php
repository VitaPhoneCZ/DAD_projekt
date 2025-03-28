<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || !isset($_SESSION['user_id'])) {
    die('Není přihlášený uživatel.');
}

include 'db.php'; // Připojení k databázi

// Ověření, zda je v URL parametr id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Neplatné ID ticketu.');
}

$ticket_id = intval($_GET['id']); // Ochrana proti SQL injection
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id']; // ID přihlášeného uživatele

// Dotaz na konkrétní ticket + sloupec `closed_at`
$sql = "SELECT tickets.id, tickets.title, tickets.description, tickets.status, tickets.created_at, tickets.closed_at, users.id AS owner_id, users.name 
        FROM tickets 
        JOIN users ON tickets.user_id = users.id 
        WHERE tickets.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();

// Ověření, zda ticket existuje
if ($result->num_rows === 0) {
    die('Ticket nenalezen.');
}

$ticket = $result->fetch_assoc();

// Pokud NENÍ přihlášený IT, musí být ticket jeho
if ($role !== 'it' && $ticket['owner_id'] != $user_id) {
    die('Nemáte oprávnění zobrazit tento ticket.');
}

// Zpracování zprávy (PHP část)
if (isset($_POST['submit_message'])) {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $sql = "INSERT INTO ticket_replies (ticket_id, user_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $ticket_id, $user_id, $message);
        if ($stmt->execute()) {
            // Po úspěšném vložení zprávy přesměruj zpět na tuto stránku, aby se zpráva zobrazila
            header("Location: ticket_detail.php?id=" . $ticket_id);
            exit();
        } else {
            echo "Chyba při odesílání zprávy.";
        }
    } else {
        echo "Zpráva nesmí být prázdná.";
    }
}

// Uzavření ticketu (pokud tlačítko bylo stisknuto)
if (isset($_POST['close_ticket'])) {
    // Nejprve uzavřeme ticket
    $sql = "UPDATE tickets SET status = 'Uzavřený', closed_at = NOW() WHERE id = ? AND status != 'Uzavřený'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticket_id);
    if ($stmt->execute()) {
        // Přidání odpovědi o uzavření ticketu
        $user_name = $_SESSION['user_name']; // Předpokládáme, že jméno uživatele je uloženo v session
        $close_message = "Ticket byl uživatelem uzavřen" . htmlspecialchars($user_name);

        // Vložení odpovědi do ticket_replies
        $sql_reply = "INSERT INTO ticket_replies (ticket_id, user_id, message) VALUES (?, ?, ?)";
        $stmt_reply = $conn->prepare($sql_reply);
        $stmt_reply->bind_param("iis", $ticket_id, $user_id, $close_message);
        $stmt_reply->execute();

        // Přesměrování na tuto stránku po uzavření ticketu
        header("Location: ticket_detail.php?id=" . $ticket_id);
        exit();
    } else {
        echo "Chyba při uzavírání ticketu.";
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Detail ticketu</title>
    <link rel="stylesheet" href="s/style.css">
    <script>
        // Potvrzovací dialog pro uzavření ticketu
        function confirmClose() {
            return confirm("Chcete opravdu uzavřít tento ticket?");
        }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <h2>Detail ticketu</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <td><?= $ticket['id'] ?></td>
        </tr>
        <tr>
            <th>Název</th>
            <td><?= htmlspecialchars($ticket['title']) ?></td>
        </tr>
        <tr>
            <th>Popis</th>
            <td><?= nl2br(htmlspecialchars($ticket['description'])) ?></td>
        </tr>
        <tr>
            <th>Stav</th>
            <td>
                <?php if ($ticket['status'] === 'Otevřený'): ?>
                    <span style="color: green;">Otevřený</span>
                <?php else: ?>
                    <span style="color: red;">Uzavřený</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Vytvořil</th>
            <td><?= htmlspecialchars($ticket['name']) ?></td>
        </tr>
        <tr>
            <th>Vytvořeno</th>
            <td><?= $ticket['created_at'] ?></td>
        </tr>

        <!-- Zobrazení closed_at pouze pokud je ticket uzavřený -->
        <?php if ($ticket['status'] === 'Uzavřený' && !empty($ticket['closed_at'])): ?>
        <tr>
            <th>Uzavřeno</th>
            <td><?= $ticket['closed_at'] ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <!-- Dynamické tlačítko "Zpět" podle stavu ticketu -->
    <p><a href="<?= ($ticket['status'] === 'Otevřený') ? 'dashboard.php' : 'tickets.php' ?>">← Zpět na seznam</a></p>

    <!-- Formulář pro odeslání zprávy, pokud ticket není uzavřený -->
    <?php if ($ticket['status'] === 'Otevřený'): ?>
        <form action="ticket_detail.php?id=<?= $ticket['id'] ?>" method="POST">
            <label for="message">Napište zprávu:</label>
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br>
            <button type="submit" name="submit_message">Odeslat zprávu</button>
        </form>
    <?php endif; ?>

    <!-- Tlačítko pro uzavření ticketu, pokud je otevřený -->
    <?php if ($ticket['status'] === 'Otevřený' && ($role === 'it' || $ticket['owner_id'] == $user_id)): ?>
        <form action="ticket_detail.php?id=<?= $ticket['id'] ?>" method="POST" onsubmit="return confirmClose()">
            <button type="submit" name="close_ticket">Uzavřít ticket</button>
        </form>
    <?php endif; ?>

    <!-- Zobrazení odpovědí na ticket -->
    <h3>Odpovědi:</h3>
    <?php
    // Dotaz pro získání odpovědí k ticketu
    $sql_replies = "SELECT ticket_replies.message, ticket_replies.created_at, users.name 
                    FROM ticket_replies 
                    JOIN users ON ticket_replies.user_id = users.id 
                    WHERE ticket_replies.ticket_id = ?
                    ORDER BY ticket_replies.created_at ASC";

    $stmt_replies = $conn->prepare($sql_replies);
    $stmt_replies->bind_param("i", $ticket_id);
    $stmt_replies->execute();
    $result_replies = $stmt_replies->get_result();

    // Zobrazení odpovědí
    while ($reply = $result_replies->fetch_assoc()) {
        echo "<div><strong>" . htmlspecialchars($reply['name']) . "</strong> (" . $reply['created_at'] . "): <br>" . nl2br(htmlspecialchars($reply['message'])) . "</div><hr>";
    }
    ?>
</body>
</html>
