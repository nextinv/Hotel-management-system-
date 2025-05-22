<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Booking Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h3>📅 Booking Management</h3>

  <form id="bookingForm" class="row g-3 mb-4">
    <input type="hidden" id="booking_id">
    <div class="col-md-3">
      <select id="guest_id" class="form-control" required>
        <option value="">Select Guest</option>
        <?php
          $guests = $conn->query("SELECT id, full_name FROM guests");
          while($g = $guests->fetch_assoc()) {
            echo "<option value='{$g['id']}'>{$g['full_name']}</option>";
          }
        ?>
      </select>
    </div>
    <div class="col-md-3">
      <select id="room_id" class="form-control" required>
        <option value="">Select Room</option>
        <?php
          $rooms = $conn->query("SELECT id, room_number FROM rooms WHERE status='Available'");
          while($r = $rooms->fetch_assoc()) {
            echo "<option value='{$r['id']}'>Room {$r['room_number']}</option>";
          }
        ?>
      </select>
    </div>
    <div class="col-md-2">
      <input type="date" id="check_in" class="form-control" required>
    </div>
    <div class="col-md-2">
      <input type="date" id="check_out" class="form-control" required>
    </div>
    <div class="col-md-2">
      <input type="number" id="total_amount" class="form-control" placeholder="Amount" required>
    </div>
    <div class="col-md-6">
      <button type="submit" class="btn btn-success w-100">Book Room</button>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Guest</th>
        <th>Room</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="bookingData"></tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadBookings() {
  $.get('ajax/booking.php', { action: 'list' }, function(data) {
    $('#bookingData').html(data);
  });
}
loadBookings();

$('#bookingForm').on('submit', function(e) {
  e.preventDefault();
  $.post('ajax/booking.php', {
    action: 'save',
    booking_id: $('#booking_id').val(),
    guest_id: $('#guest_id').val(),
    room_id: $('#room_id').val(),
    check_in: $('#check_in').val(),
    check_out: $('#check_out').val(),
    total_amount: $('#total_amount').val()
  }, function(response) {
    alert(response);
    $('#bookingForm')[0].reset();
    $('#booking_id').val('');
    loadBookings();
  });
});

function deleteBooking(id) {
  if (confirm("Delete this booking?")) {
    $.post('ajax/booking.php', { action: 'delete', id: id }, function(response) {
      alert(response);
      loadBookings();
    });
  }
}
</script>
</body>
</html>
