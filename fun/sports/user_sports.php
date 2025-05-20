<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports News</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            margin: 0; /* Remove default body margin */
            padding-top: 100px; /* Adjust top padding to accommodate navbar */
            padding-bottom: 60px; /* Adjust bottom padding to accommodate footer */
        }
        .container {
            max-width: 800px; /* Increased container width */
            margin: 20px auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap; /* Allow cards to wrap to the next line */
            justify-content: space-between; /* Distribute cards evenly */
        }
        .sport-card {
            width: calc(33.33% - 20px); /* Adjusted card width for 3 cards per row */
            margin-bottom: 40px; /* More space between cards */
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: box-shadow 0.3s ease-in-out;
            box-sizing: border-box;
        }
        .sport-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .sport-card img {
            width: 100%;
            height: 200px; /* Adjusted image height */
            object-fit: cover;
        }
        .sport-card-content {
            padding: 20px;
        }
        .sport-card h2 {
            font-size: 24px; /* Adjusted headline size */
            margin-bottom: 10px; /* Adjusted spacing */
        }
        .sport-card p {
            font-size: 14px; /* Adjusted text size for better readability */
            margin-bottom: 5px; /* Adjusted spacing */
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
        .footer {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 10px 20px;
            width: 100%;
            position: fixed;
            bottom: 0;
            z-index: 999;
            backdrop-filter: blur(8px); /* Apply blur effect */
            display: flex;
            justify-content: center; /* Center items horizontally */
            align-items: center; /* Center items vertically */
            box-sizing: border-box; /* Add box-sizing to prevent width overflow */
        }
    </style>
</head>
<body>
<div class="navbar">
    <div class="navbar-logo">
        <img src="fu.png" alt="Logo">
    </div>
    <div class="navbar-menu">
   
        <ul>
            <li><a href="../welcome.php">Home</a></li>
            <li><a href="user_sports.php">Schedule</a></li>
            <li><a href="../../hello/view.php">Live Match</a></li>
            <li><a href="../Result.html">Results</a></li>
            <li><a href="../../highlights/view.php">Highlights</a></li>
            <li><a href="../user_details.php">User Details</a></li>
        </ul>
    </div>
</div>
    
    <h1 style="text-align:center;">Schedule</h1> <!-- Adjusted heading position -->
    <div class="container">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sportsdb";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve sports from the database
        $sql = "SELECT * FROM sports";
        $result = $conn->query($sql);

        // Check if there are any sports in the database
        if ($result->num_rows > 0) {
            // Output data of each row
            $counter = 0;
            while($row = $result->fetch_assoc()) {
                if ($counter % 6 == 0) {
                    echo '<div style="width: 100%;"></div>'; // Empty div for clearing
                }
                echo '<div class="sport-card">';
                if (!empty($row["image_path"])) {
                    echo '<img src="' . $row["image_path"] . '" alt="' . $row["name"] . '">';
                } else {
                    echo '<img src="default_image.jpg" alt="Sport Image">';
                }
                echo '<div class="sport-card-content">';
                echo '<h2>' . $row["name"] . '</h2>';
                echo '<p><strong>Date:</strong> ' . $row["date"] . '</p>';
                echo '<p><strong>Venue:</strong> ' . $row["venue"] . '</p>';
                echo '<p>' . $row["description"] . '</p>';
                echo '</div>';
                echo '</div>';
                $counter++;
            }
        } else {
            echo "No sports found.";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
    <div class="footer">
        <h1 style="text-align: center;">FunOlympics-2024</h1>
        <img src="fu.png" alt="Footer Logo" width="80">
    </div>
</body>
</html>
