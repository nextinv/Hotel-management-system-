<?php
session_start();
include('includes/db.php');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Date references
$today = date('Y-m-d');
$week_ago = date('Y-m-d', strtotime('-7 days'));

// Analytics queries
$checkins_today = $conn->query("SELECT COUNT(*) AS total FROM tbl_checkin WHERE checkin_date = '$today'")->fetch_assoc()['total'];
$revenue_today = $conn->query("SELECT SUM(amount) AS total FROM tbl_payments WHERE DATE(payment_date) = '$today'")->fetch_assoc()['total'] ?? 0;
$weekly_revenue = $conn->query("SELECT SUM(amount) AS total FROM tbl_payments WHERE DATE(payment_date) >= '$week_ago'")->fetch_assoc()['total'] ?? 0;

$occupied = $conn->query("SELECT COUNT(*) AS total FROM tbl_checkin WHERE checkout_date IS NULL")->fetch_assoc()['total'];
$total_rooms = $conn->query("SELECT COUNT(*) AS total FROM tbl_rooms")->fetch_assoc()['total'];
$occupancy_rate = $total_rooms > 0 ? round(($occupied / $total_rooms) * 100) : 0;

// Feedback chart data
$feedbackData = $conn->query("
  SELECT rating, COUNT(*) AS count 
  FROM tbl_guest_feedback 
  GROUP BY rating ORDER BY rating ASC
");

$ratings = [];
$counts = [];

while($row = $feedbackData->fetch_assoc()) {
  $ratings[] = $row['rating'];
  $counts[] = $row['count'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - Hotel Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .card h6 { font-size: 16px; }
    .card h3 { font-size: 28px; font-weight: bold; }
  </style>
</head>
<body class="bg-light">

<div class="container mt-4">
  <h2 class="mb-4">📊 Hotel Analytics Dashboard</h2>

  <div class="row g-3">
    <div class="col-md-3">
      <div class="card bg-white shadow-sm">
        <div class="card-body text-center">
          <h6>Check-Ins Today</h6>
          <h3><?= $checkins_today ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-white shadow-sm">
        <div class="card-body text-center">
          <h6>Revenue Today</h6>
          <h3>₹<?= $revenue_today ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-white shadow-sm">
        <div class="card-body text-center">
          <h6>7-Day Revenue</h6>
          <h3>₹<?= $weekly_revenue ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-white shadow-sm">
        <div class="card-body text-center">
          <h6>Occupancy Rate</h6>
          <h3><?= $occupancy_rate ?>%</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5">
    <h5>📈 Guest Satisfaction (Feedback)</h5>
    <canvas id="feedbackChart"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('feedbackChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($ratings) ?>,
      datasets: [{
        label: 'Guest Ratings',
        data: <?= json_encode($counts) ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Number of Guests' }
        },
        x: {
          title: { display: true, text: 'Rating (1-5)' }
        }
      }
    }
  });
</script>

</body>
</html>
