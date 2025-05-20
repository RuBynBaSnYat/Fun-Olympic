<?php
// Include database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "highlights";

// Check if the comment ID is provided via POST
if(isset($_POST['id'])) {
    $comment_id = $_POST['id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a delete statement
    $delete_query = "DELETE FROM comments WHERE id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $comment_id);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Return success response
        echo "Comment deleted successfully";
    } else {
        // Return error response
        echo "Error deleting comment: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If comment ID is not provided, return error response
    echo "Error: Comment ID not provided.";
}
?>
