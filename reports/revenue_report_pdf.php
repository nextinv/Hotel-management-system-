<?php
require_once '../vendor/autoload.php';  // path to autoload.php

use Dompdf\Dompdf;

include('../includes/db.php');

// Fetch revenue data (example: daily revenue last month)
$sql = "SELECT DATE(checkout_date) as date, SUM(amount) as total_revenue
        FROM tbl_payments
        WHERE checkout_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
        GROUP BY DATE(checkout_date)
        ORDER BY date ASC";

$result = $conn->query($sql);

$html = '<h2>Revenue Report (Last 30 Days)</h2><table border="1" cellspacing="0" cellpadding="5">';
$html .= '<tr><th>Date</th><th>Total Revenue (₹)</th></tr>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr><td>' . $row['date'] . '</td><td>' . number_format($row['total_revenue'], 2) . '</td></tr>';
}

$html .= '</table>';

// Instantiate and use Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to browser
$dompdf->stream("revenue_report.pdf", ["Attachment" => false]);
exit;
