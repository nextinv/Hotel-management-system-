<?php
require '../vendor/autoload.php';
include('../includes/db.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch revenue data same as PDF
$sql = "SELECT DATE(checkout_date) as date, SUM(amount) as total_revenue
        FROM tbl_payments
        WHERE checkout_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
        GROUP BY DATE(checkout_date)
        ORDER BY date ASC";

$result = $conn->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Date');
$sheet->setCellValue('B1', 'Total Revenue (₹)');

$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['date']);
    $sheet->setCellValue('B' . $rowNum, $row['total_revenue']);
    $rowNum++;
}

$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="revenue_report.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
