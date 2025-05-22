<?php
session_start();
include('../includes/db.php');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Fetch user from database
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "success";
    } else {
        echo "❌ Incorrect password.";
    }
} else {
    echo "❌ User not found.";
}
