include('includes/email.php');

// Assuming $guest_email and $guest_name are available
$subject = "Booking Confirmation - Your Stay at Our Hotel";
$message = "
<html>
<body>
    <h2>Dear $guest_name,</h2>
    <p>Thank you for booking with us. Your booking is confirmed.</p>
    <p><strong>Check-in Date:</strong> $checkin_date<br>
    <strong>Room:</strong> $room_number</p>
    <p>We look forward to your stay!</p>
    <br><p>Best Regards,<br>Hotel Team</p>
</body>
</html>
";

send_email($guest_email, $subject, $message);
