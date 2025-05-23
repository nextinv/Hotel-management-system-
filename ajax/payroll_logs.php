<?php
include("includes/header.php");
include("includes/db.php");

$result = $conn->query("
  SELECT p.*, u.name FROM tbl_payroll p 
  JOIN users u ON p.staff_id = u.id
  ORDER BY month DESC
");
?>

<div class="container mt-4">
  <h4>📊 Payroll Summary</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Month</th><th>Staff</th><th>Present</th><th>Leaves</th><th>Absent</th><th>Total Salary</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['month'] ?></td>
          <td><?= $row['name'] ?></td>
          <td><?= $row['days_present'] ?></td>
          <td><?= $row['leaves'] ?></td>
          <td><?= $row['absents'] ?></td>
          <td>₹<?= number_format($row['total_salary'], 2) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
