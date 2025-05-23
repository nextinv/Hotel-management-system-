<?php
include("includes/header.php");
include("includes/db.php");

$requests = $conn->query("
  SELECT r.*, g.name AS guest_name, s.service_name
  FROM tbl_service_requests r
  JOIN tbl_guests g ON r.guest_id = g.id
  JOIN tbl_services s ON r.service_id = s.id
  ORDER BY request_time DESC
");
?>

<div class="container mt-4">
  <h4>📥 Service Requests</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Guest</th><th>Room</th><th>Service</th><th>Time</th><th>Status</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $requests->fetch_assoc()): ?>
        <tr>
          <td><?= $row['guest_name'] ?></td>
          <td><?= $row['room_number'] ?></td>
          <td><?= $row['service_name'] ?></td>
          <td><?= $row['request_time'] ?></td>
          <td><?= $row['status'] ?></td>
          <td>
            <?php if ($row['status'] == 'Pending'): ?>
              <a href="ajax/mark_service_done.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Mark Completed</a>
            <?php else: ?>
              ✅
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
