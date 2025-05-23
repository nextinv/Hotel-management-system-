<?php
include("includes/header.php");
include("includes/db.php");

$month = date("Y-m");

$staffs = $conn->query("SELECT id, name FROM users WHERE role != 'admin'");
?>

<div class="container mt-4">
  <h4>💰 Generate Payroll</h4>
  <form method="post" action="ajax/process_payroll.php" class="row g-3">
    <div class="col-md-4">
      <label>Select Month</label>
      <input type="month" name="month" value="<?= $month ?>" class="form-control" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-success">Generate Payroll</button>
    </div>
  </form>
</div>
