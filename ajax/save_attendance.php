<?php
include("../includes/db.php");

$staff_id = $_POST['staff_id'];
$status = $_POST['status'];
$date = $_POST['date'];

if (!$staff_id || !$status || !$date) {
  die("Missing input");
}

$check = $conn->prepare("SELECT * FROM tbl_attendance WHERE staff_id = ? AND date = ?");
$check->bind_param("is", $staff_id, $date);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
  // Update
  $conn->query("UPDATE tbl_attendance SET status = '$status' WHERE staff_id = $staff_id AND date = '$date'");
} else {
  // Insert
  $conn->query("INSERT INTO tbl_attendance (staff_id, date, status) VALUES ($staff_id, '$date', '$status')");
}

echo "✅ Attendance updated";
