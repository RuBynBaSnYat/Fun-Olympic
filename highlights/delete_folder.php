<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "highlights";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if folder ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $folder_id = $_GET['id'];

    // Delete folder from the database
    $query = "DELETE FROM folders WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $folder_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Highlights sports deleted successfully.'); window.location.href = 'admin_panel.php';</script>";
        exit(); // Ensure that the script stops executing after redirection
    } else {
        // If there's an error deleting the video, display the error message
        echo "<script>alert('Error deleting Highlights: " . mysqli_error($conn) . "');</script>";
    }
    // Close statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect if folder ID is not provided or invalid
    header("Location: admin_panel.php");
    exit();
}
?>
