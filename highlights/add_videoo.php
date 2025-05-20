<?php
// Include database connection code
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

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to display success or error messages
function display_message($message, $type = 'success') {
    echo "<p class='$type'>$message</p>";
}

// Check if a video is being added
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $title = sanitize_input($_POST["title"]);
    $description = sanitize_input($_POST["description"]);
    $youtube_link = sanitize_input($_POST["youtube_link"]);
    $folder_title = sanitize_input($_POST["folder_title"]);

    // Get folder ID from title
    $folder_query = "SELECT id FROM folders WHERE title=?";
    $folder_stmt = mysqli_prepare($conn, $folder_query);
    mysqli_stmt_bind_param($folder_stmt, "s", $folder_title);
    mysqli_stmt_execute($folder_stmt);
    $folder_result = mysqli_stmt_get_result($folder_stmt);
    $folder_row = mysqli_fetch_assoc($folder_result);

    if (!$folder_row) {
        die("Error: Folder not found.");
    }

    $folder_id = $folder_row['id'];

    // Insert video into database
    $video_query = "INSERT INTO videos (title, description, youtube_link, folder_id) VALUES (?, ?, ?, ?)";
    $video_stmt = mysqli_prepare($conn, $video_query);
    mysqli_stmt_bind_param($video_stmt, "sssi", $title, $description, $youtube_link, $folder_id);

    if (mysqli_stmt_execute($video_stmt)) {
        display_message("Video added successfully.");
    } else {
        display_message("Error adding video.", 'error');
    }

    // Close statements
    mysqli_stmt_close($folder_stmt);
    mysqli_stmt_close($video_stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add YouTube Video</title>
</head>
<body>
    <h2>Add YouTube Video</h2>
    <form action="" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <label for="youtube_link">YouTube Link:</label>
        <input type="text" id="youtube_link" name="youtube_link" required><br>
        <label for="folder_title">Folder:</label>
        <select id="folder_title" name="folder_title" required>
            <option value="">Select Folder</option>
            <?php
            // Fetch list of folders
            $folder_query = "SELECT title FROM folders";
            $folder_result = mysqli_query($conn, $folder_query);

            if ($folder_result) {
                while ($folder_row = mysqli_fetch_assoc($folder_result)) {
                    echo "<option value='{$folder_row['title']}'>{$folder_row['title']}</option>";
                }
            }
            ?>
        </select><br>
        <button type="submit">Add Video</button>
    </form>
</body>
</html>
