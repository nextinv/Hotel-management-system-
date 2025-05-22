<?php
include('../includes/db.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'save') {
  $id = $_POST['booking_id'] ?? '';
  $guest_id = $_POST['guest_id'];
  $room_id = $_POST['room_id'];
  $check_in = $_POST['check_in'];
  $check_out = $_POST['check_out'];
  $total_amount = $_POST['total_amount'];

  if ($id) {
    $stmt = $conn->prepare("UPDATE bookings SET guest_id=?, room_id=?, check_in=?, check_out=?, total_amount=? WHERE id=?");
    $stmt->bind_param("iissdi", $guest_id, $room_id, $check_in, $check_out, $total_amount, $id);
    $stmt->execute();
    echo "✅ Booking updated!";
  } else {
    $stmt = $conn->prepare("INSERT INTO bookings (guest_id, room_id, check_in, check_out, total_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissd", $guest_id, $room_id, $check_in, $check_out, $total_amount);
    $stmt->execute();
    $conn->query("UPDATE rooms SET status='Booked' WHERE id=$room_id");
    echo "✅ Room booked!";
  }

} elseif ($action === 'list') {
  $query = "SELECT b.*, g.full_name, r.room_number FROM bookings b 
            JOIN guests g ON b.guest_id = g.id 
            JOIN rooms r ON b.room_id = r.id 
            ORDER BY b.id DESC";
  $result = $conn->query($query);
  $output = "";
  $i = 1;
  while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
      <td>{$i}</td>
      <td>{$row['full_name']}</td>
      <td>Room {$row['room_number']}</td>
      <td>{$row['check_in']}</td>
      <td>{$row['check_out']}</td>
      <td>{$row['total_amount']}</td>
      <td>{$row['status']}</td>
      <td><button onclick=\"deleteBooking({$row['id']})\" class='btn btn-sm btn-danger'>Delete</button></td>
    </tr>";
    $i++;
  }
  echo $output;

} elseif ($action === 'delete') {
  $id = $_POST['id'];
  $get = $conn->query("SELECT room_id FROM bookings WHERE id=$id")->fetch_assoc();
  $room_id = $get['room_id'];
  $conn->query("DELETE FROM bookings WHERE id=$id");
  $conn->query("UPDATE rooms SET status='Available' WHERE id=$room_id");
  echo "🗑 Booking deleted.";
}
