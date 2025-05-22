<?php
session_start();
include 'includes/db.php';

$from = $_GET['from'] ?? date('Y-m-01');
$to   = $_GET['to'] ?? date('Y-m-d');

// Fetch data for report
$sql = $conn->prepare("
  SELECT b.*, g.name AS guest_name, r.room_number
  FROM bookings b
  JOIN guests g ON b.guest_id = g.id
  JOIN rooms r ON b.room_id = r.id
  WHERE b.checkin_date BETWEEN ? AND ?
");
$sql->bind_param("ss", $from, $to);
$sql->execute();
$result = $sql->get_result();

$total_revenue = 0;
$guests = [];
$bookings = [];
$occupied_rooms = 0;

while ($row = $result->fetch_assoc()) {
  $total_revenue += $row['total_amount'];
  $guests[] = $row['guest_name'];
  $bookings[] = $row;
  if ($row['status'] === 'Checked-In') {
    $occupied_rooms++;
  }
}
$unique_guests = count(array_unique($guests));
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reports</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h3>📊 Hotel Reports</h3>

  <form class="row g-3 mt-3 mb-4" method="get">
    <div class="col-md-3">
      <label>From Date</label>
      <input type="date" name="from" class="form-control" value="<?= $from ?>">
    </div>
    <div class="col-md-3">
      <label>To Date</label>
      <input type="date" name="to" class="form-control" value="<?= $to ?>">
    </div>
    <div class="col-md-3 align-self-end">
      <button class="btn btn-primary" type="submit">🔍 Generate</button>
    </div>
  </form>

  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h5>Total Revenue</h5>
          <h3>₹<?= number_format($total_revenue) ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success">
        <div class="card-body">
          <h5>Total Guests</h5>
          <h3><?= $unique_guests ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning">
        <div class="card-body">
          <h5>Occupied Rooms</h5>
          <h3><?= $occupied_rooms ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-dark">
        <div class="card-body">
          <h5>Total Bookings</h5>
          <h3><?= count($bookings) ?></h3>
        </div>
      </div>
    </div>
  </div>

  <h5>📋 Booking Details</h5>
  <table class="table table-bordered table-hover bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Guest</th>
        <th>Room</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Amount</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($bookings as $b): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $b['guest_name'] ?></td>
          <td><?= $b['room_number'] ?></td>
          <td><?= $b['checkin_date'] ?></td>
          <td><?= $b['checkout_date'] ?></td>
          <td>₹<?= number_format($b['total_amount']) ?></td>
          <td><span class="badge bg-info"><?= $b['status'] ?></span></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
</body>
</html>
