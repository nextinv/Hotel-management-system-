<?php
include '../includes/db.php';

$id = $_GET['id'] ?? 0;

// Update booking status
$conn->query("UPDATE bookings SET status = 'Checked-In' WHERE id = $id");

// Update room to Occupied
$conn->query("
  UPDATE rooms 
  SET status = 'Occupied' 
  WHERE id = (SELECT room_id FROM bookings WHERE id = $id)
");

header("Location: ../checkin_checkout.php");
exit;
