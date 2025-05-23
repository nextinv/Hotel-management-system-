<?php
session_start();

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
}

function check_role($roles = []) {
    if (!in_array($_SESSION['role'], $roles)) {
        // Unauthorized
        header("HTTP/1.1 403 Forbidden");
        echo "Access denied.";
        exit;
    }
}
