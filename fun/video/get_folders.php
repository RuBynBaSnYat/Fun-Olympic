<?php
// Include database connection code
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST or GET
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare and execute query to select folders and associated videos
    $query = "SELECT f.id AS folder_id, f.title AS folder_title, f.thumbnail AS folder_thumbnail, v.title AS video_title, v.youtube_link
              FROM folders f
              LEFT JOIN videos v ON f.id = v.folder_id";

    $result = $conn->query($query);

    if ($result) {
        // Fetch result rows as associative array
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Return data as JSON
        echo json_encode($data);
    } else {
        // Error handling if query fails
        echo json_encode(array('error' => 'Failed to fetch data from database.'));
    }
} else {
    // Error handling if request method is neither POST nor GET
    echo json_encode(array('error' => 'Invalid request method.'));
}

// Close database connection
$conn->close();
?>
