<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "olympic";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $title = $_POST['title'];
    $thumbnail = uploadImage($_FILES['thumbnail']);
    $schedule = $_POST['schedule'];
    $video_title = $_POST['video_title'];
    $video_link = $_POST['video_link'];
    $video_description = $_POST['video_description'];

    $sql = "INSERT INTO games (title, thumbnail, schedule, video_title, video_link, video_description) 
            VALUES ('$title', '$thumbnail', '$schedule', '$video_title', '$video_link', '$video_description')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Game added successfully!";
    } else {
        echo "Error adding game: " . $conn->error;
    }
}

// Function to upload image
function uploadImage($image) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($image["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Read
function getGames() {
    global $conn;
    $sql = "SELECT * FROM games";
    $result = $conn->query($sql);
    $games = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $games[] = $row;
        }
    }
    return $games;
}

// Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $thumbnail = uploadImage($_FILES['thumbnail']);
    $schedule = $_POST['schedule'];
    $video_title = $_POST['video_title'];
    $video_link = $_POST['video_link'];
    $video_description = $_POST['video_description'];

    $sql = "UPDATE games SET 
            title = '$title', 
            thumbnail = '$thumbnail', 
            schedule = '$schedule', 
            video_title = '$video_title', 
            video_link = '$video_link', 
            video_description = '$video_description' 
            WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Game updated successfully!";
    } else {
        echo "Error updating game: " . $conn->error;
    }
}

// Delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM games WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Game deleted successfully!";
    } else {
        echo "Error deleting game: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Games</title>
</head>
<body>

<h2>Add Game</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    Title: <input type="text" name="title"><br>
    Thumbnail: <input type="file" name="thumbnail"><br>
    Schedule: <input type="datetime-local" name="schedule"><br>
    Video Title: <input type="text" name="video_title"><br>
    YouTube Link: <input type="text" name="video_link"><br>
    Video Description: <textarea name="video_description"></textarea><br>
    <input type="submit" name="create" value="Add Game">
</form>

<h2>Games List</h2>
<?php
$games = getGames();
foreach ($games as $game) {
    echo "<div>";
    echo "<h3>{$game['title']}</h3>";
    echo "<img src='{$game['thumbnail']}' alt='Thumbnail'>";
    echo "<p>Schedule: {$game['schedule']}</p>";
    echo "<p>Video Title: {$game['video_title']}</p>";
    echo "<p>Video Description: {$game['video_description']}</p>";
    echo '<iframe width="560" height="315" src="' . $game['video_link'] . '" frameborder="0" allowfullscreen></iframe>';
    echo "</div>";
}
?>

</body>
</html>