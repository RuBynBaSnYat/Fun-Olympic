<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Folder Videos</title>
<style>
    /* Frame styling */
    .video-frame {
        border: 4px solid #333;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        position: relative;
        width: 1060px; /* Adjusted width to match the video width attribute */
        height: 515px; /* Adjusted height to match the video height attribute */
    }
    
    /* Video styling */
    .video-container {
        position: relative;
        width: 100%;
        height: 100%;
    }
    .video-container iframe {
        width: 100%;
        margin-top:20px;
        height: 90%;
        border: none;
    }
    .video-info {
        margin-top:30px;
        padding: 10px;
        background-color: white;
    }
    .like-dislike {
        margin-top: 20px;
    }
    .like-dislike button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-right: 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .like-dislike button:hover {
        background-color: #45a049;
    }
    .like-dislike button.selected {
        background-color: #007bff; /* Change to blue when selected */
    }
    .comment-form {
        margin-top: 20px;
    }
    .comment-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .comment-form input[type="submit"] {
        background-color: #008CBA;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .comment-form input[type="submit"]:hover {
        background-color: #005f7d;
    }
    .live-label {
        position: absolute;
        top: -15px;
        left: -15px;
        background-color: red;
        color: white;
        padding: 10px;
        border-radius: 5px;
        font-weight: bold;
        margin-left:16px;
        margin-top:15px;
        animation: flash 1s infinite; /* Flashing animation */
    }

    @keyframes flash {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* Recommended videos */
    .recommended-videos {
        background-color:red;
        float: right;
        width: 300px;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top:-580px;
    }
    .recommended-videos {
    float: right;
    width: 300px;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.recommended-videos h3 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 18px;
}

.recommended-videos .video {
    margin-bottom: 10px;
}

.recommended-videos .video a {
    display: block;
    color: #333;
    text-decoration: none;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: background-color 0.3s, border-color 0.3s;
}

.recommended-videos .video a:hover {
    background-color: #f0f0f0;
    border-color: #999;
}

</style>
</head>
<body>

<?php
// folder_videos.php

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

// Check if folder ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $folder_id = $_GET['id'];
    
    // Fetch folder details from the database
    $folder_query = "SELECT * FROM folders WHERE id = $folder_id";
    $folder_result = mysqli_query($conn, $folder_query);
    $folder = mysqli_fetch_assoc($folder_result);

    // Display videos associated with the folder
    if ($folder) {
        // Fetch videos associated with the folder
        $video_query = "SELECT * FROM videos WHERE folder_id = $folder_id";
        $video_result = mysqli_query($conn, $video_query);

        // Check if videos exist for the folder
        if (mysqli_num_rows($video_result) > 0) {
            // Display videos
            while ($video_row = mysqli_fetch_assoc($video_result)) {
                echo "<div class='video-frame'>";
                echo "<div class='live-label'>Live</div>";
                echo "<div class='video-container'>";
                echo "<iframe width='1060' height='515' src='{$video_row['youtube_link']}' frameborder='0' allowfullscreen></iframe>";
                echo "</div>";
                echo "<div class='video-info'>";
                echo "<h2>{$video_row['title']}</h2>";
                echo "<p>{$video_row['description']}</p>";
                echo "<div class='like-dislike'>";
                echo "<button onclick='toggleLike(this)' class='like'>Like</button>";
                echo "<button onclick='toggleDislike(this)' class='dislike'>Dislike</button>";
                echo "</div>";
                echo "<div class='comment-form'>";
                echo "<form action='comment_handler.php' method='post'>";
                echo "<textarea name='comment' rows='4' cols='50' placeholder='Write a comment...'></textarea><br>";
                echo "<input type='submit' value='Submit'>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No videos found for this folder.</p>";
        }
    } else {
        echo "<p>Folder not found.</p>";
    }
} else {
    echo "<p>Folder ID not provided.</p>";
}

// Fetch recommended videos from the database
$recommended_query = "SELECT * FROM videos WHERE folder_id != $folder_id ORDER BY RAND() LIMIT 5";
$recommended_result = mysqli_query($conn, $recommended_query);

// Check if recommended videos exist
if (mysqli_num_rows($recommended_result) > 0) {
    echo "<div class='recommended-videos'>";
    echo "<h3>Recommended Videos</h3>";
    while ($recommended_row = mysqli_fetch_assoc($recommended_result)) {
        echo "<div class='video'>";
        echo "<a href='folder_videos.php?id={$recommended_row['folder_id']}'>{$recommended_row['title']}</a>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No recommended videos found.</p>";
}

// Close connection
mysqli_close($conn);
?>

<script>
function toggleLike(button) {
  var dislikeButton = button.nextElementSibling;
  if (button.classList.contains('selected')) {
    button.classList.remove('selected');
  } else {
    button.classList.add('selected');
    dislikeButton.classList.remove('selected');
  }
}

function toggleDislike(button) {
  var likeButton = button.previousElementSibling;
  if (button.classList.contains('selected')) {
    button.classList.remove('selected');
  } else {
    button.classList.add('selected');
    likeButton.classList.remove('selected');
  }
}
</script>



</body>
</html>
