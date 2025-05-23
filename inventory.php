<?php
session_start();
include 'includes/db.php';

// Add new stock item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $stmt = $conn->prepare("INSERT INTO inventory (item_name, category, quantity, unit, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisd", $_POST['item_name'], $_POST['category'], $_POST['quantity'], $_POST['unit'], $_POST['price']);
    $stmt->execute();
    header("Location: inventory.php");
    exit;
}

// Fetch all inventory items
$result = $conn->query("SELECT * FROM inventory ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>📦 Inventory Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>📦 Inventory / Stock Management</h3>

  <!-- Add Stock Item Form -->
  <form method="POST" class="card p-4 bg-white shadow-sm mb-4">
    <input type="hidden" name="action" value="add">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Item Name</label>
        <input type="text" name="item_name" class="form-control" required>
      </div>
      <div class="col-md-3 mb-3">
        <label>Category</label>
        <input type="text" name="category" class="form-control" placeholder="e.g. Food, Cleaning" required>
      </div>
      <div class="col-md-2 mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" value="0" min="0" required>
      </div>
      <div class="col-md-2 mb-3">
        <label>Unit</label>
        <input type="text" name="unit" class="form-control" placeholder="e.g. kg, pcs">
      </div>
      <div class="col-md-3 mb-3">
        <label>Price (per unit ₹)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="0.00" min="0">
      </div>
    </div>
    <button class="btn btn-primary w-100">➕ Add Item</button>
  </form>

  <!-- Inventory List Table -->
  <table class="table table-bordered bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Item Name</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Price (₹ per unit)</th>
        <th>Added On</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($row['item_name']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= htmlspecialchars($row['unit']) ?></td>
        <td><?= number_format($row['price'], 2) ?></td>
        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
        <td>
          <a href="edit_inventory.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
          <a href="delete_inventory.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this item?')" class="btn btn-sm btn-danger">🗑 Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
