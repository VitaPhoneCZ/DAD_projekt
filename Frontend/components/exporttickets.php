<?php
// Spuštění session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kontrola přihlášení a role uživatele
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'it') {
    $_SESSION['error'] = 'Nemáte oprávnění exportovat tickety.';
    header('Location: dashboard.php');
    exit();
}

// Načtení potřebných souborů
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Získání údajů uživatele
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Příprava SQL dotazu podle role
try {
    if ($role === 'it') {
        $sql = "SELECT tickets.id, tickets.title, tickets.status, tickets.priority, tickets.platform, tickets.created_at, users.name 
                FROM tickets 
                JOIN users ON tickets.user_id = users.id 
                ORDER BY tickets.created_at DESC";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "SELECT tickets.id, tickets.title, tickets.status, tickets.priority, tickets.platform, tickets.created_at, users.name 
                FROM tickets 
                JOIN users ON tickets.user_id = users.id 
                WHERE tickets.user_id = ?
                ORDER BY tickets.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Vytvoření spreadsheetu
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Hlavička
    $sheet->fromArray(['ID', 'Název', 'Stav', 'Priorita', 'Platforma', 'Vytvořil', 'Vytvořeno'], null, 'A1');
    $sheet->getStyle('A1:G1')->getFont()->setBold(true);

    // Data
    $rowIndex = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->fromArray([
            $row['id'],
            $row['title'],
            $row['status'],
            $row['priority'],
            $row['platform'],
            $row['name'],
            $row['created_at']
        ], null, 'A' . $rowIndex);
        $rowIndex++;
    }

    // Automatické nastavení šířky sloupců
    foreach (range('A', 'G') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Hlavičky pro stažení
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="tickety.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
} catch (Exception $e) {
    $_SESSION['error'] = 'Chyba při exportu ticketů: ' . $e->getMessage();
    header('Location: dashboard.php');
    exit();
}
?>