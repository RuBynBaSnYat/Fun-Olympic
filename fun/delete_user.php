<?php
session_start();

// // Check if the user is logged in as admin, otherwise redirect to login page
// if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
//     header("Location: log.php");
//     exit();
// }

// Include the necessary files
include('db_connection.php');

// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Delete user from database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href = 'admin_dashboard.php';</script>";
        exit();
    } else {
        echo "Error deleting user.";
    }

    

    $stmt->close();
} else {
    echo "User ID not provided.";
}
?>
