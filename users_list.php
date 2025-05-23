<?php
include 'includes/auth.php';
check_login();
check_role(['admin']);

include 'includes/db.php';

$users = $conn->query("SELECT id, username, role, created_at FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>Users List</h3>
  <a href="register_user.php" class="btn btn-success mb-3">➕ Add New User</a>
  <table class="table table-bordered bg-white">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($user = $users->fetch_assoc()): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= $user['role'] ?></td>
        <td><?= $user['created_at'] ?></td>
        <td>
          <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')" class="btn btn-sm btn-danger">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>

