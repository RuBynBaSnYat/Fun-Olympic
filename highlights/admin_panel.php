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

// Check if a folder is being added
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addFolder"])) {
    // Validate and sanitize input
    $folderTitle = sanitize_input($_POST["folderTitle"]);

    // Upload thumbnail image
    $thumbnail = $_FILES["thumbnail"]["name"];
    $thumbnail_temp = $_FILES["thumbnail"]["tmp_name"];
    $thumbnail_path = "thumbnails/" . $thumbnail;

    // Move uploaded file to thumbnails directory
    if (!file_exists('thumbnails/')) {
        mkdir('thumbnails/', 0777, true); // Create thumbnails directory if it doesn't exist
    }
    move_uploaded_file($thumbnail_temp, $thumbnail_path);

    // Insert folder into database
    $query = "INSERT INTO folders (title, thumbnail) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $folderTitle, $thumbnail_path);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Highlights games has been created successfully.')</script>";
    } else {
        echo "<script>alert('Error creating games.')</script>";
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}

// Check if a video is being added
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addVideo"])) {
    // Validate and sanitize input
    $folderId = $_POST["folderId"];
    $videoTitle = sanitize_input($_POST["videoTitle"]);
    $videoDescription = sanitize_input($_POST["videoDescription"]);
    $youtubeLink = sanitize_input($_POST["youtubeLink"]);

    // Construct YouTube embed link
    $youtubeEmbedLink = $youtubeLink;

    // Insert video into database
    $query = "INSERT INTO videos (title, description, youtube_link, folder_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $videoTitle, $videoDescription, $youtubeEmbedLink, $folderId);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert(' Highlights Video added successfully.')</script>";
    } else {
        echo "<script>alert('Error adding Highlights video.')</script>";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Folder Display</title>
    <style>
        body {
            background-image: url('hello.jpg'); /* Replace 'background.jpg' with your image */
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Drop shadow effect */
            margin-top:150px;
        }

        h2 {
            margin-top: 0;
        }

        form {
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent white background for form */
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .folder-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .folder {
            width: 150px;
            margin: 10px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent white background for folders */
            border-radius: 5px;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Drop shadow effect */
        }

        .folder:hover {
            transform: scale(0.95); /* Decrease size on hover */
        }

        .folder img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .folder h3 {
            text-align: center;
            margin-top: 5px;
        }

        .folder a {
            display: block;
            text-align: center;
            margin-top: 5px;
            text-decoration: none;
            color: #333;
        }

        .folder a:hover {
            color: #666;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 15px;
            right: 15px;
            width: calc(100% - 35px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .navbar-logo img {
            width: 80px;
            margin-right: 10px; /* Adjusted margin */
        }

        .navbar-menu ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar-menu ul li {
            display: inline;
            margin-right: 20px;
        }

        .navbar-menu ul li a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar-menu ul li a:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
<div class="navbar">
        <div class="navbar-logo">
            <img src="../fun/img/fu.png" alt="Logo">
        </div>
        <div class="navbar-menu">
       
            <ul>
                <li><a href="../fun/admin_dashboard.php">Home</a></li>
                <li><a href="../highlights/admin_panel.php">Upload Highlights</a></li>
                <li><a href="../fun/sports/admin_sports.php">Upload schedule</a></li>
            </ul>
        </div>
    </div>
     <div class="container">
        <!-- Form to add new folder -->
        <h2>Add Highlights</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="folderTitle">Folder Title:</label>
            <input type="text" id="folderTitle" name="folderTitle" required>
            <label for="thumbnail">Thumbnail Image:</label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required>
            <button type="submit" name="addFolder">Create Folder</button>
        </form>

        <!-- Form to add video to folder -->
        <h2>Add Highlights Video to Games</h2>
        <form action="" method="post">
            <label for="folderId">Select Folder:</label>
            <select id="folderId" name="folderId">
                <?php
                // Fetch all folders from the database
                $query = "SELECT * FROM folders";
                $result = mysqli_query($conn, $query);

                // Check if folders exist
                if (mysqli_num_rows($result) > 0) {
                    // Display folders in dropdown
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['title']}</option>";
                    }
                } else {
                    echo "<option value=''>No folders found</option>";
                }
                ?>
            </select>
            <label for="videoTitle">Video Title:</label>
            <input type="text" id="videoTitle" name="videoTitle" required>
            <label for="videoDescription">Video Description:</label>
            <textarea id="videoDescription" name="videoDescription" required></textarea>
            <label for="youtubeLink">YouTube Video ID:</label>
            <input type="text" id="youtubeLink" name="youtubeLink" required>
            <button type="submit" name="addVideo">Add Video</button>
        </form>
        <!-- Display existing folders with animation -->
        <h2>Existing Highlights</h2>
        <div class="folder-container">
            <?php
            // Fetch all folders from the database
            $query = "SELECT * FROM folders";
            $result = mysqli_query($conn, $query);

            // Check if folders exist
            if (mysqli_num_rows($result) > 0) {
                // Display folders
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='folder'>";
                    echo "<img src='{$row['thumbnail']}' alt='Folder Thumbnail'>";
                    echo "<h3>{$row['title']}</h3>";
                    echo "<a href='edit_folder.php?id={$row['id']}'>Edit</a>";
                    echo "<a href='delete_folder.php?id={$row['id']}'>Delete</a>";
                    echo "</div>";
                }
            } else {
                echo "No folders found.";
            }
            ?>
        </div>
    </div>
</body>
</html>
