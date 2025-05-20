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
            echo "<script>alert('Highlights Video updated successfully.'); window.location.href = 'admin_panel.php';</script>";
            exit(); // Ensure that the script stops executing after redirection
        } else {
            echo "<script>alert('Error updating video.');</script>";
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
                <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
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
