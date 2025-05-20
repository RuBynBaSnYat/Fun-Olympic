<?php
// Include database connection code
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM videos WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        // Video deleted successfully
        header("Location: admin_panel.php?success=Video deleted successfully.");
        exit();
    } else {
        // Error deleting video
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Display confirmation message before deleting
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Video</title>
    </head>
    <body>
        <h2>Delete Video</h2>
        <p>Are you sure you want to delete this video?</p>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit">Yes, Delete</button>
            <a href="admin_panel.php">No, Cancel</a>
        </form>
    </body>
    </html>
    <?php
} else {
    // Redirect if video ID is not provided or invalid
    header("Location: admin_panel.php");
    exit();
}
?>
