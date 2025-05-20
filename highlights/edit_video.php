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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $youtube_link = $_POST["youtube_link"];
    $folder_title = $_POST["folder_title"];

    // Get folder ID from title
    $query = "SELECT id FROM folders WHERE title=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $folder_title);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $folder = mysqli_fetch_assoc($result);

    if (!$folder) {
        die("Error: Folder not found.");
    }

    $folder_id = $folder['id'];

    $query = "UPDATE videos SET title=?, description=?, youtube_link=?, folder_id=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssii", $title, $description, $youtube_link, $folder_id, $id);

    if (mysqli_stmt_execute($stmt)) {
        // Video updated successfully
        header("Location: admin_panel.php?success=Video updated successfully.");
        exit();
    } else {
        // Error updating video
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT v.*, f.title AS folder_title FROM videos v JOIN folders f ON v.folder_id = f.id WHERE v.id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $video = mysqli_fetch_assoc($result);
} else {
    // Redirect if video ID is not provided or invalid
    header("Location: admin_panel.php");
    exit();
}
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
        <input type="hidden" name="id" value="<?php echo $video['id']; ?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $video['title']; ?>" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo $video['description']; ?></textarea><br>
        <label for="youtube_link">YouTube Link:</label>
        <input type="text" id="youtube_link" name="youtube_link" value="<?php echo $video['youtube_link']; ?>" required><br>
        <label for="folder_title">Folder:</label>
        <select id="folder_title" name="folder_title" required>
            <?php
            // Fetch list of folders to display in the dropdown
            $query = "SELECT title FROM folders";
            $folders_result = mysqli_query($conn, $query);

            if (!$folders_result) {
                die("Error fetching folders: " . mysqli_error($conn));
            }

            while ($row = mysqli_fetch_assoc($folders_result)) {
                $selected = ($row['title'] == $video['folder_title']) ? 'selected' : '';
                echo "<option value='{$row['title']}' $selected>{$row['title']}</option>";
            }
            ?>
        </select><br>
        <button type="submit">Update Video</button>
    </form>
</body>
</html>
