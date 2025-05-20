<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folder View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .folder-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            width: 200px; /* Adjust card width */
            display: inline-block; /* Display cards in a row */
            text-align: center; /* Center align text */
            transition: background-color 0.3s;
            margin-right:20px; /* Smooth hover effect */
        }
        .folder-card:hover {
            background-color: #f0f0f0;
        }
        .folder-card h3 {
            margin-top: 10px; /* Adjust top margin for folder title */
            font-size: 18px; /* Adjust font size for folder title */
        }
        .folder-card img {
            width: 200px; /* Adjust thumbnail width */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 10px; /* Add space below thumbnail */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Folders</h2>
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

        // Fetch all folders from the database
        $query = "SELECT * FROM folders";
        $result = mysqli_query($conn, $query);

        // Check if folders exist
        if (mysqli_num_rows($result) > 0) {
            // Display folders as cards
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='folder-card' onclick=\"window.location='folder_videos.php?id={$row['id']}'\">";
                echo "<img src='{$row['thumbnail']}' alt='Folder Thumbnail'>";
                echo "<h3>{$row['title']}</h3>";
                echo "</div>";
            }
        } else {
            echo "<p>No folders found.</p>";
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
