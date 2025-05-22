<?php
session_start();
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: services.php');
    exit;
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE services SET name=?, category=?, description=?, price=?, status=? WHERE id=?");
    $stmt->bind_param("sssssi", $_POST['name'], $_POST['category'], $_POST['description'], $_POST['price'], $_POST['status'], $id);
    $stmt->execute();
    header('Location: services.php');
    exit;
}

// Fetch current service data
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
if (!$service) {
    echo "Service not found.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Service</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>Edit Service</h3>
  <form method="POST" class="card p-4 bg-white shadow-sm">
    <div class="mb-3">
      <label>Service Name</label>
      <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($service['name']) ?>">
    </div>
    <div class="mb-3">
      <label>Category</label>
      <select name="category" class="form-control" required>
        <?php
          $categories = ['Laundry', 'Food', 'Spa', 'Room Service', 'Other'];
          foreach ($categories as $cat) {
              $selected = ($service['category'] === $cat) ? 'selected' : '';
              echo "<option $selected>$cat</option>";
          }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($service['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Price (₹)</label>
      <input type="number" step="0.01" name="price" class="form-control" required value="<?= $service['price'] ?>">
    </div>
    <div class="mb-3">
      <label>Status</label>
      <select name="status" class="form-control">
        <option <?= $service['status']=='Active' ? 'selected' : '' ?>>Active</option>
        <option <?= $service['status']=='Inactive' ? 'selected' : '' ?>>Inactive</option>
      </select>
    </div>
    <button class="btn btn-success">Update Service</button>
    <a href="services.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
</body>
</html>
