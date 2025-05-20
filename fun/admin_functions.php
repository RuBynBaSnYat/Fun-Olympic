<?php
// Include database connection
include('db_connection.php');

// Function to get total number of users (excluding admins)
function getTotalUsers($conn) {
    $sql = "SELECT COUNT(*) AS total FROM users WHERE role != 'admin'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to get list of non-admin users
function getUsers($conn) {
    $sql = "SELECT * FROM users WHERE role != 'admin'";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Function to block user
function blockUser($conn, $userEmail) {
    $stmt = $conn->prepare("UPDATE users SET block_status = 1 - block_status WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $stmt->close();
}

// Function to unblock user
function unblockUser($conn, $userEmail) {
    $stmt = $conn->prepare("UPDATE users SET block_status = 1 - block_status WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $stmt->close();
}
?>
