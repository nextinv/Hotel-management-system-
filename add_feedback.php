<?php
include("includes/header.php");
include("includes/db.php");

$guests = $conn->query("SELECT id, name FROM tbl_guests WHERE check_out IS NULL OR check_out >= CURDATE()");
?>

<div class="container mt-4">
  <h4>📝 Guest Feedback</h4>
  <form method="post" action="ajax/save_feedback.php" class="row g-3">
    <div class="col-md-4">
      <label>Guest</label>
      <select name="guest_id" class="form-control" required>
        <?php while($g = $guests->fetch_assoc()): ?>
          <option value="<?= $g['id'] ?>"><?= $g['name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-2">
      <label>Rating (1-5)</label>
      <input type="number" name="rating" class="form-control" min="1" max="5" required>
    </div>
    <div class="col-md-6">
      <label>Comment</label>
      <textarea name="comment" class="form-control" rows="2"></textarea>
    </div>
    <div class="col-12">
      <button class="btn btn-success">Submit Feedback</button>
    </div>
  </form>
</div>
