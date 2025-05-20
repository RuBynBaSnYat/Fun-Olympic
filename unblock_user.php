<?php
session_start();

// Check if user is logged in and has admin role
if (!isset($_SESSION["user_email"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: log.php");
    exit();
}

// Include database connection
include('db_connection.php');
include('admin_functions.php');

// Check if user email is provided in the URL
if(isset($_GET['email'])) {
    $userEmail = $_GET['email'];

    // Block or unblock user in database
    if (blockUser($conn, $userEmail, 0)) { // 0 represents unblock status
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error unblocking user.";
    }
} else {
    echo "User email not provided.";
}
?>
