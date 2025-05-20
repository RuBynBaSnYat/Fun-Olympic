<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Folder Videos</title>
</head>
<link rel="stylesheet" href="video.css">
<style>
.video-frame {
    margin-top: 150px;
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
        }</style>
<body>

<div class="navbar">
        <div class="navbar-logo">
            <img src="../fun/img/fu.png" alt="Logo">
        </div>
        <div class="navbar-menu">
       
            <ul>
                <li><a href="../fun/welcome.php">Home</a></li>
                <li><a href="../fun/sports/user_sports.php">Schedule</a></li>
                <li><a href="../fun/Result.html">Results</a></li>
                <li><a href="../highlights/view.php">Highlights</a></li>
                <li><a href="../fun/user_details.php">User Details</a></li>
            </ul>
        </div>
    </div>
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

// Initialize $folder_id to prevent undefined variable error
$folder_id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;

// Check if folder ID is provided in the URL
if ($folder_id !== null) {
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
                echo "<div class='live-label'>Highlights</div>";
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
                echo "<form id='comment-form' action='comment_handler.php' method='post'>";
                echo "<textarea name='comment' id='comment-text' rows='4' cols='50' placeholder='Write a comment...'></textarea><br>";
                echo "<input type='hidden' name='video_id' value='{$video_row['id']}'>"; // Add a hidden field for video ID
                echo "<input type='submit' value='Submit' id='submit-comment'>";
                echo "</form>";
                echo "</div>";
                echo "<div id='comments-container'>";
                // Fetch and display existing comments for this video
                $comment_query = "SELECT * FROM comments WHERE video_id = {$video_row['id']} ORDER BY created_at DESC";
                $comment_result = mysqli_query($conn, $comment_query);
                while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                    echo "<div class='comment' id='comment-{$comment_row['id']}'>";
                    echo "<p>{$comment_row['comment_text']}</p>";
                    echo "<p>Posted on: {$comment_row['created_at']}</p>";
                    echo "<button onclick='deleteComment({$comment_row['id']})' class='delete-comment'>Delete</button>";
                    echo "</div>";
                }
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
if ($folder_id !== null) {
    $recommended_query = "SELECT * FROM videos WHERE folder_id != $folder_id ORDER BY RAND() LIMIT 5";
    $recommended_result = mysqli_query($conn, $recommended_query);

    // Check if recommended videos exist
    if ($recommended_result) {
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
    } else {
        echo "Error fetching recommended videos: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>

<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
    // Handle form submission via AJAX
    $('#comment-form').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Get form data
        var formData = $(this).serialize();

        // Send AJAX request to comment_handler.php
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                // If comment submission is successful, update comments container
                $('#comments-container').html(response);
                // Clear the comment textarea
                $('#comment-text').val('');
            }
        });
    });
});

function deleteComment(commentId) {
    // Send AJAX request to delete_comment.php
    $.ajax({
        type: 'POST',
        url: 'delete_comment.php',
        data: { id: commentId },
        success: function(response) {
            // If comment deletion is successful, remove the comment from the DOM
            $('#comment-' + commentId).remove();
        }
    });
}
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

