<?php
include("includes/header.php");
include("includes/db.php");

$res = $conn->query("
  SELECT f.*, g.name FROM tbl_guest_feedback f
  JOIN tbl_guests g ON f.guest_id = g.id
  ORDER BY submitted_at DESC
");
?>

<div class="container mt-4">
  <h4>📊 Guest Feedbacks</h4>
  <table class="table table-bordered">
    <thead>
      <tr><th>Guest</th><th>Rating</th><th>Comment</th><th>Date</th></tr>
    </thead>
    <tbody>
      <?php while($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?= $row['name'] ?></td>
          <td><?= $row['rating'] ?></td>
          <td><?= $row['comment'] ?></td>
          <td><?= $row['submitted_at'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
