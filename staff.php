<?php
session_start();
include 'includes/db.php';

// Handle insert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO staff (name, role, phone, email, salary, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $_POST['name'], $_POST['role'], $_POST['phone'], $_POST['email'], $_POST['salary'], $_POST['status']);
    $stmt->execute();
    header("Location: staff.php");
    exit;
}

// Fetch staff list
$result = $conn->query("SELECT * FROM staff ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Staff Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>👥 Staff Management</h3>

  <form method="POST" class="card shadow p-4 bg-white mb-4">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="col-md-4 mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
          <option>Manager</option>
          <option>Receptionist</option>
          <option>Housekeeping</option>
          <option>Cook</option>
          <option>Security</option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" required>
      </div>
      <div class="col-md-4 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
      </div>
      <div class="col-md-4 mb-3">
        <label>Salary (₹)</label>
        <input type="number" name="salary" class="form-control" required>
      </div>
      <div class="col-md-4 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
    </div>
    <button class="btn btn-primary w-100">➕ Add Staff</button>
  </form>

  <table class="table table-bordered bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Role</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Salary</th>
        <th>Status</th>
        <th>Joined</th>
        <th>Actions</th> <!-- Added Actions column -->
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= $row['role'] ?></td>
          <td><?= $row['phone'] ?></td>
          <td><?= $row['email'] ?></td>
          <td>₹<?= number_format($row['salary']) ?></td>
          <td><?= $row['status'] ?></td>
          <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
          <td>
            <a href="edit_staff.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
            <a href="delete_staff.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this staff?')" class="btn btn-sm btn-danger">🗑 Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
