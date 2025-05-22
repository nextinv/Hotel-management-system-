<?php
session_start();
include 'includes/db.php';

$from = $_GET['from'] ?? date('Y-m-01');
$to   = $_GET['to'] ?? date('Y-m-d');
$method = $_GET['method'] ?? '';

// Filter logic
$query = "
  SELECT p.*, b.id AS booking_id, g.name AS guest_name
  FROM payments p
  JOIN bookings b ON p.booking_id = b.id
  JOIN guests g ON b.guest_id = g.id
  WHERE p.payment_date BETWEEN ? AND ?
";

if ($method !== '') {
  $query .= " AND p.method = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sss", $from, $to, $method);
} else {
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $from, $to);
}

$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$payments = [];

while ($row = $result->fetch_assoc()) {
  $payments[] = $row;
  $total += $row['amount'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>💳 Payments Report</h3>

  <form class="row g-3 mb-4" method="get">
    <div class="col-md-3">
      <label>From</label>
      <input type="date" name="from" class="form-control" value="<?= $from ?>">
    </div>
    <div class="col-md-3">
      <label>To</label>
      <input type="date" name="to" class="form-control" value="<?= $to ?>">
    </div>
    <div class="col-md-3">
      <label>Method</label>
      <select name="method" class="form-control">
        <option value="">All</option>
        <option <?= $method === 'Cash' ? 'selected' : '' ?>>Cash</option>
        <option <?= $method === 'UPI' ? 'selected' : '' ?>>UPI</option>
        <option <?= $method === 'Card' ? 'selected' : '' ?>>Card</option>
        <option <?= $method === 'Pending' ? 'selected' : '' ?>>Pending</option>
      </select>
    </div>
    <div class="col-md-3 align-self-end">
      <button class="btn btn-primary">Filter</button>
    </div>
  </form>

  <div class="mb-3">
    <h5>Total Collected: ₹<?= number_format($total) ?></h5>
  </div>

  <table class="table table-bordered bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Guest</th>
        <th>Booking ID</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Date</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($payments as $p): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $p['guest_name'] ?></td>
          <td>#<?= $p['booking_id'] ?></td>
          <td>₹<?= $p['amount'] ?></td>
          <td><?= $p['method'] ?></td>
          <td><?= $p['payment_date'] ?></td>
          <td><?= $p['note'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
</body>
</html>
