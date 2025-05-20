<?php
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

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if video ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $video_id = $_GET['id'];
    
    // Check if the form is submitted for updating the video
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input
        $videoTitle = sanitize_input($_POST["videoTitle"]);
        $youtubeLink = sanitize_input($_POST["youtubeLink"]);

        // Update video details in the database
        $query = "UPDATE videos SET title = ?, youtube_link = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $videoTitle, $youtubeLink, $video_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: admin_panel.php?success=Video updated successfully.");
            exit();
        } else {
            echo "Error updating video.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Retrieve video details from the database
        $query = "SELECT * FROM videos WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $video_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $video = mysqli_fetch_assoc($result);

        // Display form to edit video
        if ($video) {
?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Video</title>
            </head>
            <body>
                <h2>Edit Video</h2>
                <form action="" method="post">
                    <label for="videoTitle">Video Title:</label>
                    <input type="text" id="videoTitle" name="videoTitle" value="<?php echo $video['title']; ?>" required>
                    <label for="youtubeLink">YouTube Link:</label>
                    <input type="text" id="youtubeLink" name="youtubeLink" value="<?php echo $video['youtube_link']; ?>" required>
                    <button type="submit">Update Video</button>
                </form>
            </body>
            </html>
<?php
        } else {
            echo "Video not found.";
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
    }
} else {
    // Redirect if video ID is not provided or invalid
    header("Location: admin_panel.php");
    exit();
}
?>
