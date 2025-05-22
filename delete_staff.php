<?php
session_start();
include 'includes/db.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM staff WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: staff.php?msg=deleted");
    exit;
} else {
    echo "❌ Failed to delete staff.";
}
