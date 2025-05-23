<?php
session_start();
include 'includes/db.php';

$id = $_GET['id'] ?? 0;
if (!$id) {
    header("Location: inventory.php");
    exit;
}

// Fetch item data
$stmt = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    header("Location: inventory.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE inventory SET item_name = ?, category = ?, quantity = ?, unit = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssisdi", $_POST['item_name'], $_POST['category'], $_POST['quantity'], $_POST['unit'], $_POST['price'], $id);
    $stmt->execute();
    header("Location: inventory.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Inventory Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>Edit Inventory Item</h3>
  <form method="POST" class="card p-4 bg-white shadow-sm">
    <div class="mb-3">
      <label>Item Name</label>
      <input type="text" name="item_name" class="form-control" value="<?= htmlspecialchars($item['item_name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Category</label>
      <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($item['category']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Quantity</label>
      <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?>" min="0" required>
    </div>
    <div class="mb-3">
      <label>Unit</label>
      <input type="text" name="unit" class="form-control" value="<?= htmlspecialchars($item['unit']) ?>">
    </div>
    <div class="mb-3">
      <label>Price (per unit ₹)</label>
      <input type="number" step="0.01" name="price" class="form-control" value="<?= $item['price'] ?>" min="0">
    </div>
    <button class="btn btn-success">💾 Save Changes</button>
    <a href="inventory.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
