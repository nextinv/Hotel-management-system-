<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Guest Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h3 class="mb-3">👤 Guest Management</h3>

  <form id="guestForm" class="row g-3 mb-4">
    <input type="hidden" id="guest_id">
    <div class="col-md-3">
      <input type="text" id="full_name" class="form-control" placeholder="Full Name" required>
    </div>
    <div class="col-md-3">
      <input type="text" id="phone" class="form-control" placeholder="Phone Number" required>
    </div>
    <div class="col-md-3">
      <input type="email" id="email" class="form-control" placeholder="Email">
    </div>
    <div class="col-md-3">
      <input type="text" id="id_proof" class="form-control" placeholder="ID Proof (e.g., Aadhar)">
    </div>
    <div class="col-md-6">
      <textarea id="address" class="form-control" placeholder="Address"></textarea>
    </div>
    <div class="col-md-6">
      <button type="submit" class="btn btn-primary w-100">Save Guest</button>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>ID Proof</th>
        <th>Address</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="guestData"></tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadGuests() {
  $.get('ajax/guest.php', { action: 'list' }, function(data) {
    $('#guestData').html(data);
  });
}
loadGuests();

$('#guestForm').on('submit', function(e) {
  e.preventDefault();
  $.post('ajax/guest.php', {
    action: 'save',
    id: $('#guest_id').val(),
    full_name: $('#full_name').val(),
    phone: $('#phone').val(),
    email: $('#email').val(),
    address: $('#address').val(),
    id_proof: $('#id_proof').val()
  }, function(response) {
    alert(response);
    $('#guestForm')[0].reset();
    $('#guest_id').val('');
    loadGuests();
  });
});

function editGuest(id, name, phone, email, address, id_proof) {
  $('#guest_id').val(id);
  $('#full_name').val(name);
  $('#phone').val(phone);
  $('#email').val(email);
  $('#address').val(address);
  $('#id_proof').val(id_proof);
}

function deleteGuest(id) {
  if (confirm("Delete this guest?")) {
    $.post('ajax/guest.php', { action: 'delete', id: id }, function(response) {
      alert(response);
      loadGuests();
    });
  }
}
</script>
</body>
</html>
