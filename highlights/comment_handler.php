<?php
session_start(); // Start session if not already started

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

// Check if the form is submitted, the comment is not empty, and the user is logged in
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["comment"]) && isset($_SESSION["user_email"])) {
    // Sanitize input to prevent SQL injection
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
    $video_id = $_POST["video_id"];
    $user_email = $_SESSION["user_email"]; // Retrieve user email from session

    // Insert the comment into the database
    $insert_query = "INSERT INTO comments (video_id, comment_text, user_email) VALUES ('$video_id', '$comment', '$user_email')";
    if (mysqli_query($conn, $insert_query)) {
        // Fetch and return updated comments HTML
        $comments_html = fetchCommentsHTML($conn, $video_id);
        echo $comments_html;
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
    }
} else {
    // If the form is not submitted, the comment is empty, or the user is not logged in, return an error message
    echo "Error: Comment cannot be empty or user not logged in.";
}

// Close connection
mysqli_close($conn);

// Function to fetch and return comments HTML
function fetchCommentsHTML($conn, $video_id) {
    $comments_html = '';

    // Fetch comments for the video
    $comment_query = "SELECT * FROM comments WHERE video_id = $video_id ORDER BY created_at DESC";
    $comment_result = mysqli_query($conn, $comment_query);

    // Build comments HTML
    while ($comment_row = mysqli_fetch_assoc($comment_result)) {
        $comments_html .= "<div class='comment' id='comment-{$comment_row['id']}'>";
        $comments_html .= "<p>{$comment_row['comment_text']}</p>";
        $comments_html .= "<p>Posted by: {$comment_row['user_email']} on {$comment_row['created_at']}</p>";
        $comments_html .= "<button onclick='deleteComment({$comment_row['id']})' class='delete-comment'>Delete</button>";
        $comments_html .= "</div>";
    }

    return $comments_html;
}
?>
