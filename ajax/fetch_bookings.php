<?php
include '../includes/db.php';

$query = $conn->query("
  SELECT b.*, g.name AS guest_name, r.room_number
  FROM bookings b 
  JOIN guests g ON b.guest_id = g.id
  JOIN rooms r ON b.room_id = r.id
");

$events = [];

while ($row = $query->fetch_assoc()) {
  $events[] = [
    'id'    => $row['id'],
    'title' => 'Room ' . $row['room_number'],
    'guest' => $row['guest_name'],
    'start' => $row['checkin_date'],
    'end'   => date('Y-m-d', strtotime($row['checkout_date'] . ' +1 day')), // FullCalendar is exclusive of end date
  ];
}

header('Content-Type: application/json');
echo json_encode($events);
