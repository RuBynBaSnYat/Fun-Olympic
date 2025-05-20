<?php
// Include the database connection file
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    // Prepare and execute SQL statement to update user details in the database
    $stmt = $conn->prepare("UPDATE users SET firstName = ?, lastName = ? WHERE id = ?");
    $stmt->bind_param("ssi", $firstName, $lastName, $user_id);

    if ($stmt->execute()) {
        // User details updated successfully
        header("Location: user_details.php?id=$user_id&success=User details updated successfully.");
        exit();
    } else {
        // Error updating user details
        header("Location: user_details.php?id=$user_id&error=Error updating user details.");
        exit();
    }

    // Close statement
    $stmt->close();
}
?>
