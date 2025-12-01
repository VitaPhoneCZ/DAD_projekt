<?php
// Spuštění session
session_start();

// Načtení potřebných souborů
include __DIR__ . '/components/db.php';
include __DIR__ . '/components/post_login_header.php';

// Kontrola přihlášení uživatele
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || !isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Není přihlášený uživatel.';
    header('Location: login.php');
    exit();
}

// Kontrola platnosti ID ticketu
$ticket_id = $_GET['id'] ?? 0;
if (!$ticket_id || !is_numeric($ticket_id)) {
    $_SESSION['error'] = 'Neplatné ID ticketu.';
    header('Location: tickets.php');
    exit();
}

$ticket_id = (int)$ticket_id;
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Načtení detailů ticketu
$stmt = $conn->prepare("SELECT tickets.id, tickets.title, tickets.description, tickets.status, tickets.priority, tickets.created_at, tickets.closed_at, users.id AS owner_id, users.name 
                        FROM tickets 
                        JOIN users ON tickets.user_id = users.id 
                        WHERE tickets.id = ?");
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Ticket nenalezen.';
    header('Location: tickets.php');
    exit();
}

$ticket = $result->fetch_assoc();

// Kontrola oprávnění
if ($role !== 'it' && $ticket['owner_id'] !== $user_id) {
    $_SESSION['error'] = 'Nemáte oprávnění zobrazit tento ticket.';
    header('Location: tickets.php');
    exit();
}

// Zpracování odeslání zprávy
$zprava = '';
if (isset($_POST['submit_message'])) {
    $message = trim($_POST['message'] ?? '');
    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO ticket_replies (ticket_id, user_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $ticket_id, $user_id, $message);
        if ($stmt->execute()) {
            $zprava = 'Zpráva byla úspěšně odeslána.';
        } else {
            $zprava = 'Chyba při odesílání zprávy.';
        }
    } else {
        $zprava = 'Zpráva nesmí být prázdná.';
    }
}

// Zpracování uzavření ticketu
if (isset($_POST['close_ticket'])) {
    $stmt = $conn->prepare("UPDATE tickets SET status = 'Uzavřený', closed_at = NOW() WHERE id = ? AND status != 'Uzavřený'");
    $stmt->bind_param("i", $ticket_id);
    if ($stmt->execute()) {
        $user_name = $_SESSION['user'];
        $close_message = "Ticket byl uživatelem uzavřen " . htmlspecialchars($user_name);

        $stmt_reply = $conn->prepare("INSERT INTO ticket_replies (ticket_id, user_id, message) VALUES (?, ?, ?)");
        $stmt_reply->bind_param("iis", $ticket_id, $user_id, $close_message);
        $stmt_reply->execute();

        $zprava = 'Ticket byl úspěšně uzavřen.';
    } else {
        $zprava = 'Chyba při uzavírání ticketu.';
    }
}

// Načtení odpovědí k ticketu
$stmt_replies = $conn->prepare("SELECT ticket_replies.*, users.name 
                                FROM ticket_replies 
                                JOIN users ON ticket_replies.user_id = users.id 
                                WHERE ticket_replies.ticket_id = ? 
                                ORDER BY ticket_replies.created_at ASC");
$stmt_replies->bind_param("i", $ticket_id);
$stmt_replies->execute();
$result_replies = $stmt_replies->get_result();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail ticketu | Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
        function confirmClose() {
            return confirm("Chcete opravdu uzavřít tento ticket?");
        }
    </script>
</head>
<body class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark-mode' : '' ?>">
    <!-- Detaily ticketu a odpovědi -->
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="text-primary mb-4">
                    <i class="fas fa-info-circle"></i> Detail ticketu
                </h2>

                <?php if (!empty($zprava)): ?>
                    <div class="alert alert-info" role="alert" style="border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <i class="fas fa-info-circle"></i> <?= htmlspecialchars($zprava) ?>
                    </div>
                <?php endif; ?>

                <table class="table table-bordered align-middle">
                    <tr>
                        <th style="width: 200px;">ID</th>
                        <td><?= htmlspecialchars($ticket['id']) ?></td>
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
                        <td><?= htmlspecialchars($ticket['created_at']) ?></td>
                    </tr>
                    <?php if ($ticket['status'] === 'Uzavřený' && !empty($ticket['closed_at'])): ?>
                        <tr>
                            <th>Uzavřeno</th>
                            <td><?= htmlspecialchars($ticket['closed_at']) ?></td>
                        </tr>
                    <?php endif; ?>
                </table>

                <div class="my-4">
                    <a href="<?= ($ticket['status'] === 'Otevřený') ? 'dashboard.php' : 'tickets.php' ?>" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left"></i> Zpět na seznam
                    </a>
                </div>

                <?php if ($ticket['status'] === 'Otevřený'): ?>
                    <div class="mb-4">
                        <form action="ticket_detail.php?id=<?= $ticket_id ?>" method="POST">
                            <div class="mb-3">
                                <label for="message" class="form-label">Napište zprávu:</label>
                                <textarea id="message" name="message" class="form-control rounded-3" rows="4" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                            </div>
                            <button type="submit" name="submit_message" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-paper-plane"></i> Odeslat zprávu
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if ($ticket['status'] === 'Otevřený' && ($role === 'it' || $ticket['owner_id'] === $user_id)): ?>
                    <form action="ticket_detail.php?id=<?= $ticket_id ?>" method="POST" onsubmit="return confirmClose()" class="mb-4">
                        <button type="submit" name="close_ticket" class="btn btn-danger rounded-pill px-4">
                            <i class="fas fa-times-circle"></i> Uzavřít ticket
                        </button>
                    </form>
                <?php endif; ?>

                <h3 class="mt-5 mb-3">
                    <i class="fas fa-comments"></i> Odpovědi:
                </h3>
                <?php while ($reply = $result_replies->fetch_assoc()): ?>
                    <div class="bg-light p-3 rounded-3 mb-3 shadow-sm reply-message" style="border-left: 4px solid #6366f1;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user-circle me-2" style="color: #6366f1; font-size: 1.2rem;"></i>
                            <strong><?= htmlspecialchars($reply['name']) ?></strong>
                            <span class="text-muted small ms-2">(<?= htmlspecialchars($reply['created_at']) ?>)</span>
                        </div>
                        <p class="mb-0" style="margin-top: 0.5rem;"><?= nl2br(htmlspecialchars($reply['message'])) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>