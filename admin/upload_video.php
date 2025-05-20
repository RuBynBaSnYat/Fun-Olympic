<?php
// Include the database connection file
include('admin_db_connection.php');

// Initialize variables for storing upload status
$uploadStatus = '';
$uploadError = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["videoFile"]) && $_FILES["videoFile"]["error"] == 0) {
        // Define upload directory and file path
        $uploadDirectory = "uploads/videos/";
        $uploadFilePath = $uploadDirectory . basename($_FILES["videoFile"]["name"]);
        
        // Check if file already exists
        if (file_exists($uploadFilePath)) {
            $uploadError = "File already exists.";
        } else {
            // Attempt to move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $uploadFilePath)) {
                // File uploaded successfully, generate thumbnail
                $thumbnailPath = generateThumbnail($uploadFilePath);

                // Insert video details into database
                $title = $_POST['title'];
                $uploadedBy = $_POST['uploadedBy']; // Assuming admin ID is submitted via a hidden input field
                
                $sql = "INSERT INTO uploaded_videos (title, file_path, thumbnail_path, uploaded_by) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $title, $uploadFilePath, $thumbnailPath, $uploadedBy);

                if ($stmt->execute()) {
                    $uploadStatus = "File uploaded successfully.";
                } else {
                    $uploadError = "Error uploading file.";
                }

                $stmt->close();
            } else {
                $uploadError = "Error uploading file.";
            }
        }
    } else {
        $uploadError = "No file uploaded or file upload error occurred.";
    }
}

// Function to generate thumbnail using FFmpeg
function generateThumbnail($videoFilePath) {
    // Define thumbnail directory and file path
    $thumbnailDirectory = "uploads/thumbnails/";
    $thumbnailFileName = pathinfo($videoFilePath, PATHINFO_FILENAME) . ".jpg";
    $thumbnailFilePath = $thumbnailDirectory . $thumbnailFileName;

    // Command to generate thumbnail using FFmpeg
    $ffmpegCommand = "ffmpeg -i " . escapeshellarg($videoFilePath) . " -ss 00:00:01 -vframes 1 -q:v 2 " . escapeshellarg($thumbnailFilePath);

    // Execute FFmpeg command
    exec($ffmpegCommand);

    // Return thumbnail file path
    return $thumbnailFilePath;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
</head>
<body>
    <h1>Upload Video</h1>
    <?php if ($uploadStatus): ?>
        <p><?php echo $uploadStatus; ?></p>
    <?php endif; ?>
    <?php if ($uploadError): ?>
        <p><?php echo $uploadError; ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="videoFile">Select video to upload:</label>
        <input type="file" id="videoFile" name="videoFile" required onchange="displayThumbnail(this);"><br><br>
        <img id="thumbnailPreview" src="" alt="Thumbnail Preview" style="max-width: 200px; display: none;"><br><br>
        <!-- Assuming admin ID is submitted via a hidden input field -->
        <input type="hidden" name="uploadedBy" value="admin_id">
        <input type="submit" value="Upload Video">
    </form>

    <script>
        // Function to display thumbnail preview when a video file is selected
        function displayThumbnail(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('thumbnailPreview').src = e.target.result;
                    document.getElementById('thumbnailPreview').style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
