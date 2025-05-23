<?php
include("../includes/db.php");

$guest_id = $_POST['guest_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

$conn->query("INSERT INTO tbl_guest_feedback (guest_id, rating, comment)
  VALUES ($guest_id, $rating, '$comment')");

header("Location: ../add_feedback.php");
