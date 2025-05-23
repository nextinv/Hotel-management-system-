<?php
include("includes/header.php");
include("includes/db.php");

$guests = $conn->query("SELECT id, name FROM tbl_guests WHERE check_out IS NULL");
?>

<div class="container mt-4">
  <h4>🍽 Assign Meal Plan</h4>
  <form action="ajax/save_meal_plan.php" method="post" class="row g-3">
    <div class="col-md-4">
      <label>Guest</label>
      <select name="guest_id" class="form-control" required>
        <option value="">Select</option>
        <?php while($g = $guests->fetch_assoc()): ?>
          <option value="<?= $g['id'] ?>"><?= $g['name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label>Date</label>
      <input type="date" name="date" class="form-control" required>
    </div>
    <div class="col-md-5">
      <label>Meals</label><br>
      <label><input type="checkbox" name="breakfast" value="1"> Breakfast</label>
      <label><input type="checkbox" name="lunch" value="1"> Lunch</label>
      <label><input type="checkbox" name="dinner" value="1"> Dinner</label>
    </div>
    <div class="col-12">
      <button class="btn btn-primary">Save Plan</button>
    </div>
  </form>
</div>
