<?php
include("../includes/db.php");

$guest_id = $_POST['guest_id'];
$service_id = $_POST['service_id'];

if (!$guest_id || !$service_id) {
  die("❌ Required fields missing.");
}

// Get room number
$q = $conn->query("SELECT room_number FROM tbl_guests WHERE id = $guest_id");
$room = $q->fetch_assoc();

$conn->query("
  INSERT INTO tbl_service_requests (guest_id, service_id, room_number)
  VALUES ($guest_id, $service_id, '{$room['room_number']}')
");

echo "✅ Service Request Added.";
