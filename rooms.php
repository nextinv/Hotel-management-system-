<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Rooms</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3 class="mb-3">🛏 Manage Rooms</h3>

  <form id="roomForm" class="row g-3 mb-4">
    <input type="hidden" id="room_id" value="">
    <div class="col-md-3">
      <input type="text" id="room_number" class="form-control" placeholder="Room Number" required>
    </div>
    <div class="col-md-3">
      <select id="room_type" class="form-control" required>
        <option value="">Select Room Type</option>
        <option value="Single">Single</option>
        <option value="Double">Double</option>
        <option value="Suite">Suite</option>
      </select>
    </div>
    <div class="col-md-3">
      <input type="number" id="price" class="form-control" placeholder="Price" required>
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-success w-100">Save Room</button>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Room Number</th>
        <th>Type</th>
        <th>Status</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="roomData"></tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadRooms() {
  $.get('ajax/room.php', { action: 'list' }, function(data) {
    $('#roomData').html(data);
  });
}
loadRooms();

$('#roomForm').on('submit', function(e) {
  e.preventDefault();
  $.post('ajax/room.php', {
    action: 'save',
    id: $('#room_id').val(),
    room_number: $('#room_number').val(),
    room_type: $('#room_type').val(),
    price: $('#price').val()
  }, function(response) {
    alert(response);
    $('#roomForm')[0].reset();
    $('#room_id').val('');
    loadRooms();
  });
});

function editRoom(id, number, type, price) {
  $('#room_id').val(id);
  $('#room_number').val(number);
  $('#room_type').val(type);
  $('#price').val(price);
}

function deleteRoom(id) {
  if (confirm("Are you sure to delete this room?")) {
    $.post('ajax/room.php', { action: 'delete', id: id }, function(response) {
      alert(response);
      loadRooms();
    });
  }
}
</script>
</body>
</html>
