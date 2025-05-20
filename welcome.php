<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["user_email"])) {
    header("Location: log.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
        /* Your additional CSS styles for this page */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('img/reg.jpg'); /* Background image URL */
            background-size: cover;
            background-position: center;
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

        .welcome-container {
            text-align: center;
            padding-top: 100px;
            margin: 0 auto;
            max-width: 600px;
        }

        .welcome-message h1 {
            color: white;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .welcome-message p {
            color: white;
            font-size: 18px;
            margin-bottom: 50px;
        }

        .live-match-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .live-match-button a:hover {
            background-color: #45a049;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .footer-logo img {
            width: 50px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .footer-text {
            color: white;
            font-size: 14px;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="navbar-logo">
        <img src="img/fu.png" alt="Logo">
    </div>
    <div class="navbar-menu">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="../fun/sports/user_sports.php">Schedule</a></li>
            <li><a href="../newsfeed/index.php">News</a></li>
            <li><a href="../fun/Result.html">Results</a></li>
            <li><a href="../highlights/view.php">Highlights</a></li>
            <li><a href="../fun/user_details.php">User Details</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<div class="welcome-container">
    <div class="welcome-message">
        <h1>Welcome, <?php echo $_SESSION['user_email']; ?></h1>
        <p>Welcome to our website. Enjoy your stay!</p>
    </div>

    <div class="live-match-button">
        <a href="../hello/view.php">Click here to watch live match</a>
    </div>
</div>

<div class="footer">
    <div class="footer-logo">
        <img src="img/fu.png" alt="Logo">
    </div>
    <div class="footer-text">
        &copy; Funolympic 2024
    </div>
</div>

</body>
</html>
