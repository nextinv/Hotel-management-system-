<?php
include('../includes/db.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'save') {
  $id = $_POST['id'] ?? '';
  $full_name = $_POST['full_name'] ?? '';
  $phone = $_POST['phone'] ?? '';
  $email = $_POST['email'] ?? '';
  $address = $_POST['address'] ?? '';
  $id_proof = $_POST['id_proof'] ?? '';

  if ($id) {
    $stmt = $conn->prepare("UPDATE guests SET full_name=?, phone=?, email=?, address=?, id_proof=? WHERE id=?");
    $stmt->bind_param("sssssi", $full_name, $phone, $email, $address, $id_proof, $id);
    $stmt->execute();
    echo "✅ Guest updated!";
  } else {
    $stmt = $conn->prepare("INSERT INTO guests (full_name, phone, email, address, id_proof) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $phone, $email, $address, $id_proof);
    $stmt->execute();
    echo "✅ Guest added!";
  }

} elseif ($action === 'list') {
  $result = $conn->query("SELECT * FROM guests ORDER BY id DESC");
  $output = "";
  $i = 1;
  while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
      <td>{$i}</td>
      <td>{$row['full_name']}</td>
      <td>{$row['phone']}</td>
      <td>{$row['email']}</td>
      <td>{$row['id_proof']}</td>
      <td>{$row['address']}</td>
      <td>
        <button onclick=\"editGuest('{$row['id']}', '{$row['full_name']}', '{$row['phone']}', '{$row['email']}', `{$row['address']}`, '{$row['id_proof']}')\" class='btn btn-sm btn-warning'>Edit</button>
        <button onclick=\"deleteGuest({$row['id']})\" class='btn btn-sm btn-danger'>Delete</button>
      </td>
    </tr>";
    $i++;
  }
  echo $output;

} elseif ($action === 'delete') {
  $id = $_POST['id'] ?? '';
  $conn->query("DELETE FROM guests WHERE id = $id");
  echo "🗑 Guest deleted.";
}
