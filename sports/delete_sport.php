<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportsdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$delete_sport_id = $_GET['id']; // Use $_GET to retrieve the sport ID passed in the URL

// Delete sport from the database
$sql_select = "SELECT image_path FROM sports WHERE id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $delete_sport_id);
$stmt_select->execute();
$stmt_select->store_result();

if ($stmt_select->num_rows > 0) {
    $stmt_select->bind_result($image_path);
    $stmt_select->fetch();
    
    if (!empty($image_path)) {
        unlink($image_path); // Delete the image file from the server
    }

    $stmt_select->close();

    $sql_delete = "DELETE FROM sports WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_sport_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Sport deleted successfully')</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $stmt_delete->error . "')</script>";
    }

    $stmt_delete->close();
} else {
    echo "<script>alert('Error selecting record: No sport found with the provided ID')</script>";
}

$conn->close();

// Redirect back to admin_sports.php
echo "<script>window.location.href = 'admin_sports.php';</script>";
?>
