<?php
session_start();
include 'includes/db.php';

$booking_id = $_GET['booking_id'] ?? 0;

$query = $conn->query("
  SELECT b.*, g.name as guest_name, g.email, g.phone, 
         r.room_number, r.type, r.price
  FROM bookings b 
  JOIN guests g ON b.guest_id = g.id
  JOIN rooms r ON b.room_id = r.id
  WHERE b.id = $booking_id
");

if ($query->num_rows === 0) {
  die("❌ Invalid Booking ID");
}

$data = $query->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Booking Invoice</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .invoice-box {
      padding: 30px;
      border: 1px solid #eee;
      background: #fff;
    }
    @media print {
      .btn-print {
        display: none;
      }
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-4">
  <div class="invoice-box shadow-sm">
    <div class="d-flex justify-content-between">
      <h4>🧾 Hotel Booking Invoice</h4>
      <button class="btn btn-primary btn-sm btn-print" onclick="window.print()">🖨️ Print</button>
    </div>
    <hr>

    <div class="row">
      <div class="col-md-6">
        <h6>Guest Details</h6>
        <p>
          <strong>Name:</strong> <?= $data['guest_name'] ?><br>
          <strong>Email:</strong> <?= $data['email'] ?><br>
          <strong>Phone:</strong> <?= $data['phone'] ?>
        </p>
      </div>
      <div class="col-md-6 text-end">
        <h6>Invoice Details</h6>
        <p>
          <strong>Invoice #:</strong> <?= $data['id'] ?><br>
          <strong>Date:</strong> <?= date('d M Y') ?>
        </p>
      </div>
    </div>

    <h6 class="mt-4">Booking Information</h6>
    <table class="table table-bordered">
      <tr>
        <th>Room Number</th>
        <td><?= $data['room_number'] ?></td>
      </tr>
      <tr>
        <th>Room Type</th>
        <td><?= $data['type'] ?></td>
      </tr>
      <tr>
        <th>Price / Night</th>
        <td>₹<?= $data['price'] ?></td>
      </tr>
      <tr>
        <th>Check-In</th>
        <td><?= $data['checkin_date'] ?></td>
      </tr>
      <tr>
        <th>Check-Out</th>
        <td><?= $data['checkout_date'] ?></td>
      </tr>
      <tr>
        <th>Total Amount</th>
        <td><strong>₹<?= number_format($data['total_amount']) ?></strong></td>
      </tr>
      <tr>
        <th>Status</th>
        <td><?= $data['status'] ?></td>
      </tr>
    </table>
  </div>
</div>

</body>
</html>
