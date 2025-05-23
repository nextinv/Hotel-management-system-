<?php
include("includes/header.php");
include("includes/db.php");

$logs = $conn->query("
  SELECT a.*, u.name, u.role 
  FROM tbl_attendance a
  JOIN users u ON a.staff_id = u.id
  ORDER BY date DESC
");
?>

<div class="container mt-4">
  <h4>📋 Attendance Logs</h4>
  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>Date</th><th>Name</th><th>Role</th><th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $logs->fetch_assoc()): ?>
        <tr>
          <td><?= $row['date'] ?></td>
          <td><?= $row['name'] ?></td>
          <td><?= ucfirst($row['role']) ?></td>
          <td><?= $row['status'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
