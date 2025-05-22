<?php
session_start();
include 'includes/db.php';

$id = $_GET['id'] ?? 0;
$msg = '';

// Get staff data
$stmt = $conn->prepare("SELECT * FROM staff WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  die("❌ Staff not found.");
}
$staff = $result->fetch_assoc();

// Update form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE staff SET name=?, role=?, phone=?, email=?, salary=?, status=? WHERE id=?");
    $stmt->bind_param("ssssdsi", $_POST['name'], $_POST['role'], $_POST['phone'], $_POST['email'], $_POST['salary'], $_POST['status'], $id);
    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">✅ Staff updated successfully.</div>';
        $staff = array_merge($staff, $_POST); // Update local array
    } else {
        $msg = '<div class="alert alert-danger">❌ Update failed.</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Staff</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>📝 Edit Staff</h3>
  <?= $msg ?>
  <form method="POST" class="card p-4 shadow-sm bg-white">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($staff['name']) ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
          <?php
          $roles = ['Manager', 'Receptionist', 'Housekeeping', 'Cook', 'Security'];
          foreach ($roles as $r) {
              $sel = $r === $staff['role'] ? 'selected' : '';
              echo "<option $sel>$r</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-6 mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= $staff['phone'] ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= $staff['email'] ?>">
      </div>
      <div class="col-md-6 mb-3">
        <label>Salary (₹)</label>
        <input type="number" name="salary" class="form-control" value="<?= $staff['salary'] ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
          <option <?= $staff['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
          <option <?= $staff['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
      </div>
    </div>
    <button class="btn btn-primary">💾 Update Staff</button>
    <a href="staff.php" class="btn btn-secondary ms-2">🔙 Back</a>
  </form>
</div>
</body>
</html>
