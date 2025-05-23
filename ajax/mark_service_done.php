<?php
include("../includes/db.php");

$id = $_GET['id'] ?? 0;
if ($id) {
  $conn->query("UPDATE tbl_service_requests SET status = 'Completed' WHERE id = $id");
}
header("Location: ../service_requests.php");
