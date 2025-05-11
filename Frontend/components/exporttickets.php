<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

require 'vendor/autoload.php'; // Načtení knihovny PhpSpreadsheet
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Hlavička
$sheet->fromArray(['ID', 'Název', 'Stav', 'Priorita', 'Platforma', 'Vytvořil', 'Vytvořeno'], NULL, 'A1');

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
    ], NULL, 'A' . $rowIndex);
    $rowIndex++;
}

// Hlavičky pro stažení
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="tickety.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
