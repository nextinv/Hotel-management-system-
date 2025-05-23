<?php
function send_email($to, $subject, $message) {
    $headers = "From: no-reply@yourhotel.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($to, $subject, $message, $headers);
}
