<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root'; // Change this to your admin database username
$dbPassword = ''; // Change this to your admin database password
$dbName = 'admin_database'; // Change this to your admin database name

// Create database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert uploaded video details into the database
function insertUploadedVideo($title, $filePath, $thumbnailPath, $uploadedBy) {
    global $conn;
    $sql = "INSERT INTO uploaded_videos (title, file_path, thumbnail_path, uploaded_by) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $filePath, $thumbnailPath, $uploadedBy);
    return $stmt->execute();
}

// Function to retrieve all uploaded videos from the database
function getAllUploadedVideos() {
    global $conn;
    $sql = "SELECT * FROM uploaded_videos";
    $result = $conn->query($sql);
    $videos = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $videos[] = $row;
        }
    }
    return $videos;
}

// Add more functions as needed for other database operations related to uploaded videos
?>
