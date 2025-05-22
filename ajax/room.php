<?php
include('../includes/db.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'save') {
  $id = $_POST['id'] ?? '';
  $room_number = $_POST['room_number'] ?? '';
  $room_type = $_POST['room_type'] ?? '';
  $price = $_POST['price'] ?? '';

  if ($id) {
    $stmt = $conn->prepare("UPDATE rooms SET room_number=?, room_type=?, price=? WHERE id=?");
    $stmt->bind_param("ssdi", $room_number, $room_type, $price, $id);
    $stmt->execute();
    echo "✅ Room updated successfully!";
  } else {
    $stmt = $conn->prepare("INSERT INTO rooms (room_number, room_type, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $room_number, $room_type, $price);
    $stmt->execute();
    echo "✅ Room added successfully!";
  }

} elseif ($action === 'list') {
  $result = $conn->query("SELECT * FROM rooms ORDER BY id DESC");
  $output = "";
  $i = 1;
  while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
      <td>{$i}</td>
      <td>{$row['room_number']}</td>
      <td>{$row['room_type']}</td>
      <td>{$row['status']}</td>
      <td>{$row['price']}</td>
      <td>
        <button onclick=\"editRoom('{$row['id']}', '{$row['room_number']}', '{$row['room_type']}', '{$row['price']}')\" class='btn btn-sm btn-warning'>Edit</button>
        <button onclick=\"deleteRoom({$row['id']})\" class='btn btn-sm btn-danger'>Delete</button>
      </td>
    </tr>";
    $i++;
  }
  echo $output;

} elseif ($action === 'delete') {
  $id = $_POST['id'] ?? '';
  $conn->query("DELETE FROM rooms WHERE id = $id");
  echo "🗑 Room deleted.";
}
