include('includes/email.php');

$subject = "Payment Received - Hotel Stay";
$message = "
<html><body>
<p>Dear $guest_name,</p>
<p>We have received your payment of <b>₹$amount</b>.</p>
<p>Thank you for your prompt payment!</p>
<p>Regards,<br>Hotel Management</p>
</body></html>
";

send_email($guest_email, $subject, $message);
