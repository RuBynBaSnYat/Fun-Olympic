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
            margin-top:100px;
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
                <li><a href="../fun/welcome.php">Home</a></li>
                <li><a href="../fun/sports/user_sports.php">Schedule</a></li>
                <li><a href="../fun/Result.html">Results</a></li>
                <li><a href="../highlights/view.php">Highlights</a></li>
                <li><a href="../fun/user_details.php">User Details</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <h2>Highlights</h2>
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
