<?php
session_start();
include 'includes/db.php';

// Handle Add Service form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $stmt = $conn->prepare("INSERT INTO services (name, category, description, price, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $_POST['name'], $_POST['category'], $_POST['description'], $_POST['price'], $_POST['status']);
    $stmt->execute();
    header("Location: services.php");
    exit;
}

// Fetch all services for listing
$result = $conn->query("SELECT * FROM services ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>🧺 Manage Hotel Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>🧺 Hotel Services Management</h3>

  <!-- Add Service Form -->
  <form method="POST" class="card p-4 bg-white shadow-sm mb-4">
    <input type="hidden" name="action" value="add">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Service Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="col-md-4 mb-3">
        <label>Category</label>
        <select name="category" class="form-control" required>
          <option>Laundry</option>
          <option>Food</option>
          <option>Spa</option>
          <option>Room Service</option>
          <option>Other</option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label>Price (₹)</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
      </div>
      <div class="col-md-12 mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="2"></textarea>
      </div>
      <div class="col-md-4 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
    </div>
    <button class="btn btn-primary w-100">➕ Add Service</button>
  </form>

  <!-- Services List Table -->
  <table class="table table-bordered bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Category</th>
        <th>Description</th>
        <th>Price (₹)</th>
        <th>Status</th>
        <th>Added On</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['category'] ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td><?= number_format($row['price'], 2) ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
        <td>
          <a href="edit_service.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
          <a href="delete_service.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this service?')" class="btn btn-sm btn-danger">🗑 Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
