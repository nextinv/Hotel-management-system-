<?php
include("includes/header.php"); // checks session
include("includes/db.php");

$staffs = $conn->query("SELECT * FROM users WHERE role != 'admin'");
?>

<div class="container mt-4">
  <h4 class="mb-3">🕒 Staff Attendance</h4>
  <form method="post" action="ajax/save_attendance.php" class="row g-3">
    <div class="col-md-4">
      <label>Select Staff</label>
      <select name="staff_id" class="form-control" required>
        <option value="">Choose...</option>
        <?php while ($row = $staffs->fetch_assoc()): ?>
          <option value="<?= $row['id'] ?>"><?= $row['name'] ?> (<?= $row['role'] ?>)</option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label>Status</label>
      <select name="status" class="form-control" required>
        <option value="Present">Present</option>
        <option value="Leave">Leave</option>
        <option value="Absent">Absent</option>
      </select>
    </div>
    <div class="col-md-4">
      <label>Date</label>
      <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </div>
  </form>
</div>
