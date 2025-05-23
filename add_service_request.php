<?php
include("includes/header.php");
include("includes/db.php");

$guests = $conn->query("SELECT id, name, room_number FROM tbl_guests WHERE check_out IS NULL");
$services = $conn->query("SELECT * FROM tbl_services");
?>

<div class="container mt-4">
  <h4>🛎 Add Service Request</h4>
  <form method="post" action="ajax/save_service_request.php" class="row g-3">
    <div class="col-md-4">
      <label>Guest</label>
      <select name="guest_id" class="form-control" required>
        <option value="">Select</option>
        <?php while($g = $guests->fetch_assoc()): ?>
          <option value="<?= $g['id'] ?>"><?= $g['name'] ?> (Room: <?= $g['room_number'] ?>)</option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label>Service</label>
      <select name="service_id" class="form-control" required>
        <option value="">Choose</option>
        <?php while($s = $services->fetch_assoc()): ?>
          <option value="<?= $s['id'] ?>"><?= $s['service_name'] ?> - ₹<?= $s['price'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Add Request</button>
    </div>
  </form>
</div>
