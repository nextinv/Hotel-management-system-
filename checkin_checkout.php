<?php
session_start();
include 'includes/db.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Check-In / Check-Out</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h3>🛎️ Check-In / Check-Out Management</h3>

  <table class="table table-bordered table-hover mt-4 bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Guest</th>
        <th>Room</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $today = date('Y-m-d');
        $sql = $conn->query("
          SELECT b.*, g.name as guest_name, r.room_number 
          FROM bookings b
          JOIN guests g ON b.guest_id = g.id
          JOIN rooms r ON b.room_id = r.id
          WHERE b.checkin_date <= '$today' AND b.status != 'Checked-Out'
          ORDER BY b.checkin_date DESC
        ");

        $i = 1;
        while ($row = $sql->fetch_assoc()):
      ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $row['guest_name'] ?></td>
          <td><?= $row['room_number'] ?></td>
          <td><?= $row['checkin_date'] ?></td>
          <td><?= $row['checkout_date'] ?></td>
          <td><span class="badge bg-info"><?= $row['status'] ?></span></td>
          <td>
            <?php if ($row['status'] == 'Pending'): ?>
              <a href="ajax/checkin.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Check-In</a>
            <?php elseif ($row['status'] == 'Checked-In'): ?>
              <a href="ajax/checkout.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Check-Out</a>
            <?php else: ?>
              <span class="text-muted">Completed</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
