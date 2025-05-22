<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Hotel Management Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header text-center bg-primary text-white">
            <h4>Hotel Login</h4>
          </div>
          <div class="card-body">
            <form id="loginForm">
              <div class="mb-3">
                <label>Username</label>
                <input type="text" id="username" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" id="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
              <div id="error" class="text-danger mt-2"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#loginForm').on('submit', function(e) {
      e.preventDefault();
      $.post('ajax/login.php', {
        username: $('#username').val(),
        password: $('#password').val()
      }, function(response) {
        if (response.trim() === 'success') {
          window.location.href = 'dashboard.php';
        } else {
          $('#error').text(response);
        }
      });
    });
  </script>
</body>
</html>
