<?php
session_start();
include 'includes/db.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h3 class="mb-4">🏨 Hotel Dashboard</h3>

  <div class="row g-3">

    <div class="col-md-3">
      <div class="card text-white bg-primary shadow">
        <div class="card-body">
          <h5>Total Rooms</h5>
          <h2>
            <?php
              $r = $conn->query("SELECT COUNT(*) as total FROM rooms")->fetch_assoc();
              echo $r['total'];
            ?>
          </h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-success shadow">
        <div class="card-body">
          <h5>Available Rooms</h5>
          <h2>
            <?php
              $r = $conn->query("SELECT COUNT(*) as total FROM rooms WHERE status='Available'")->fetch_assoc();
              echo $r['total'];
            ?>
          </h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-info shadow">
        <div class="card-body">
          <h5>Total Guests</h5>
          <h2>
            <?php
              $r = $conn->query("SELECT COUNT(*) as total FROM guests")->fetch_assoc();
              echo $r['total'];
            ?>
          </h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-warning shadow">
        <div class="card-body">
          <h5>Total Bookings</h5>
          <h2>
            <?php
              $r = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc();
              echo $r['total'];
            ?>
          </h2>
        </div>
      </div>
    </div>

    <div class="col-md-4 mt-4">
      <div class="card text-white bg-dark shadow">
        <div class="card-body">
          <h5>Total Revenue</h5>
          <h2>
            ₹<?php
              $r = $conn->query("SELECT SUM(total_amount) as revenue FROM bookings")->fetch_assoc();
              echo $r['revenue'] ? number_format($r['revenue']) : '0';
            ?>
          </h2>
        </div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
