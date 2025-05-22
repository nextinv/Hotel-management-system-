<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkin_id = intval($_POST['checkin_id']);
    $service_id = intval($_POST['service_id']);
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("INSERT INTO service_requests (checkin_id, service_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $checkin_id, $service_id, $quantity);
    $stmt->execute();

    header("Location: view_checkin.php?id=$checkin_id"); // or some confirmation page
    exit;
}

// Fetch active checkins and services for form
$checkins = $conn->query("SELECT c.id, r.name as guest_name FROM checkin c JOIN registration r ON c.registration_id = r.id WHERE c.status='Checked In'");
$services = $conn->query("SELECT * FROM services WHERE status='Active' ORDER BY name");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Request Service</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>Request Service for Guest</h3>
  <form method="POST" class="card p-4 bg-white shadow-sm">
    <div class="mb-3">
      <label>Guest (Check-In)</label>
      <select name="checkin_id" class="form-control" required>
        <option value="">Select Guest</option>
        <?php while($row = $checkins->fetch_assoc()): ?>
          <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['guest_name']) ?> (ID: <?= $row['id'] ?>)</option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Service</label>
      <select name="service_id" class="form-control" required>
        <option value="">Select Service</option>
        <?php while($row = $services->fetch_assoc()): ?>
          <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?> - ₹<?= number_format($row['price'], 2) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Quantity</label>
      <input type="number" name="quantity" min="1" value="1" class="form-control" required>
    </div>
    <button class="btn btn-primary">Add Service Request</button>
  </form>
</div>
</body>
</html>
