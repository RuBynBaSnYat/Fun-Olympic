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
$sport_name = $_POST['sport_name'];
$sport_description = $_POST['sport_description'];
$sport_date = $_POST['sport_date'];
$sport_venue = $_POST['sport_venue'];

// File upload handling
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["sport_image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is uploaded
if ($_FILES["sport_image"]["size"] > 0) {
    // Your existing image validation code goes here
}

// Create the target directory if it doesn't exist
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true); // Create directory with full permissions (0777)
}

// Move uploaded file to target directory
if (move_uploaded_file($_FILES["sport_image"]["tmp_name"], $target_file)) {
    // Insert new sport into the database
    $sql = "INSERT INTO sports (name, description, date, venue, image_path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $sport_name, $sport_description, $sport_date, $sport_venue, $target_file);

    if ($stmt->execute()) {
        echo "<script>alert('New sport added successfully')</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "')</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
}

$conn->close();

// Redirect back to admin_sports.php
echo "<script>window.location.href = 'admin_sports.php';</script>";
?>
