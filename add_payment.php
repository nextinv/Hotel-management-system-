<?php
session_start();
include 'includes/db.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $note = $_POST['note'];
    $payment_date = $_POST['payment_date'];

    $stmt = $conn->prepare("INSERT INTO payments (booking_id, amount, method, note, payment_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $booking_id, $amount, $method, $note, $payment_date);

    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">Payment added successfully.</div>';
    } else {
        $msg = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
    }
}

// Fetch existing bookings to show in dropdown
$bookingResult = $conn->query("SELECT b.id, g.name FROM bookings b JOIN guests g ON b.guest_id = g.id ORDER BY b.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>➕ Add New Payment</h3>
    <?= $msg ?>

    <form method="post" class="card shadow p-4 bg-white">
        <div class="mb-3">
            <label>Booking (Guest)</label>
            <select name="booking_id" class="form-control" required>
                <option value="">Select Booking</option>
                <?php while($row = $bookingResult->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>">#<?= $row['id'] ?> – <?= htmlspecialchars($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Amount (₹)</label>
            <input type="number" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Method</label>
            <select name="method" class="form-control" required>
                <option value="Cash">Cash</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
                <option value="Pending">Pending</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Payment Date</label>
            <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label>Note (optional)</label>
            <textarea name="note" class="form-control" rows="2"></textarea>
        </div>

        <button class="btn btn-success w-100">💾 Save Payment</button>
    </form>
</div>
</body>
</html>
