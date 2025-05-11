<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || !isset($_SESSION['user_id'])) {
    die('Není přihlášený uživatel.');
}

include 'components/db.php'; // Připojení k databázi

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Neplatné ID ticketu.');
}

$ticket_id = intval($_GET['id']);
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT tickets.id, tickets.title, tickets.description, tickets.status, tickets.priority, tickets.created_at, tickets.closed_at, users.id AS owner_id, users.name 
        FROM tickets 
        JOIN users ON tickets.user_id = users.id 
        WHERE tickets.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Ticket nenalezen.');
}

$ticket = $result->fetch_assoc();

if ($role !== 'it' && $ticket['owner_id'] != $user_id) {
    die('Nemáte oprávnění zobrazit tento ticket.');
}

if (isset($_POST['submit_message'])) {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $sql = "INSERT INTO ticket_replies (ticket_id, user_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $ticket_id, $user_id, $message);
        if ($stmt->execute()) {
            header("Location: ticket_detail.php?id=" . $ticket_id);
            exit();
        } else {
            echo "Chyba při odesílání zprávy.";
        }
    } else {
        echo "Zpráva nesmí být prázdná.";
    }
}

if (isset($_POST['close_ticket'])) {
    $sql = "UPDATE tickets SET status = 'Uzavřený', closed_at = NOW() WHERE id = ? AND status != 'Uzavřený'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticket_id);
    if ($stmt->execute()) {
        $user_name = $_SESSION['user_name'];
        $close_message = "Ticket byl uživatelem uzavřen " . htmlspecialchars($user_name);

        $sql_reply = "INSERT INTO ticket_replies (ticket_id, user_id, message) VALUES (?, ?, ?)";
        $stmt_reply = $conn->prepare($sql_reply);
        $stmt_reply->bind_param("iis", $ticket_id, $user_id, $close_message);
        $stmt_reply->execute();

        header("Location: ticket_detail.php?id=" . $ticket_id);
        exit();
    } else {
        echo "Chyba při uzavírání ticketu.";
    }
}

// Získání odpovědí
$sql_replies = "SELECT ticket_replies.*, users.name FROM ticket_replies JOIN users ON ticket_replies.user_id = users.id WHERE ticket_replies.ticket_id = ? ORDER BY ticket_replies.created_at ASC";
$stmt_replies = $conn->prepare($sql_replies);
$stmt_replies->bind_param("i", $ticket_id);
$stmt_replies->execute();
$result_replies = $stmt_replies->get_result();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Detail ticketu | Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <script>
        function confirmClose() {
            return confirm("Chcete opravdu uzavřít tento ticket?");
        }
    </script>
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">

<?php include 'components/post_login_header.php'; ?>

<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <h2 class="text-primary mb-4">Detail ticketu</h2>

            <table class="table table-bordered align-middle">
                <tr>
                    <th style="width: 200px;">ID</th>
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
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Otevřený</span>
                        <?php else: ?>
                            <span class="badge bg-success rounded-pill px-3 py-2">Uzavřený</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Priorita</th>
                    <td>
                        <?php
                        $priority_colors = [
                            'Nízká' => 'success',
                            'Střední' => 'warning',
                            'Vysoká' => 'danger'
                        ];
                        $color = $priority_colors[$ticket['priority']] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?= $color ?> rounded-pill px-3 py-2"><?= htmlspecialchars($ticket['priority']) ?></span>
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
                <?php if ($ticket['status'] === 'Uzavřený' && !empty($ticket['closed_at'])): ?>
                    <tr>
                        <th>Uzavřeno</th>
                        <td><?= $ticket['closed_at'] ?></td>
                    </tr>
                <?php endif; ?>
            </table>

            <div class="my-4">
                <a href="<?= ($ticket['status'] === 'Otevřený') ? 'dashboard.php' : 'tickets.php' ?>" class="btn btn-outline-secondary rounded-pill px-4">
                    ← Zpět na seznam
                </a>
            </div>

            <?php if ($ticket['status'] === 'Otevřený'): ?>
                <div class="mb-4">
                    <form action="ticket_detail.php?id=<?= $ticket['id'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="message" class="form-label">Napište zprávu:</label>
                            <textarea id="message" name="message" class="form-control rounded-3" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="submit_message" class="btn btn-primary rounded-pill px-4">Odeslat zprávu</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($ticket['status'] === 'Otevřený' && ($role === 'it' || $ticket['owner_id'] == $user_id)): ?>
                <form action="ticket_detail.php?id=<?= $ticket['id'] ?>" method="POST" onsubmit="return confirmClose()" class="mb-4">
                    <button type="submit" name="close_ticket" class="btn btn-danger rounded-pill px-4">Uzavřít ticket</button>
                </form>
            <?php endif; ?>

            <h3 class="mt-5 mb-3">Odpovědi:</h3>
            <?php
            while ($reply = $result_replies->fetch_assoc()) {
                echo '<div class="bg-light p-3 rounded-3 mb-3 shadow-sm">';
                echo '<strong>' . htmlspecialchars($reply['name']) . '</strong> ';
                echo '<span class="text-muted small">(' . $reply['created_at'] . ')</span><br>';
                echo nl2br(htmlspecialchars($reply['message']));
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
