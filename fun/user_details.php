<?php
session_start();

// Include the database connection file
include('db_connection.php');

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_email'])) {
    header("Location: log.php");
    exit();
}

// Retrieve user data from the database based on the session email
$userEmail = $_SESSION['user_email'];

$stmt = $conn->prepare("SELECT firstName, lastName, sex, country, sports FROM users WHERE email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    // User not found, handle error
    echo "Error: User data not found.";
}

// Close the statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        /* Your CSS styles for user details page */

/* Your CSS styles for user details page */

/* Your CSS styles for user details page */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.nav-bar {
    background-color: #333;
    color: white;
    padding: 5px 10px; /* Adjusted padding */
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-bar img {
    width: 60px; /* Adjusted width for the logo */
}

.nav-links a {
    color: white;
    text-decoration: none;
    margin-left: 5px; /* Adjusted margin */
    font-size: 14px; /* Adjusted font size */
}

.container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container h2 {
    margin-top: 0;
}

.container div {
    margin-bottom: 10px;
}

.container label {
    font-weight: bold;
}

.container span {
    display: inline-block;
    margin-left: 10px;
}

footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}

footer img {
    width: 80px; /* Adjusted width */
    height: auto;
    margin-top: -5px;
}


    </style> <!-- Include your CSS file -->
</head>
<body>

<div class="nav-bar">
    <img src="img/fu.png" alt="Logo">
    <h1>FUN OLYMPIC 2024</h1>
    <div class="nav-links">
            <a href="welcome.php">Home</a>
            <a href="../fun/sports/user_sports.php">Schedule</a>
            <a href="../hello/view.php">Live match</a>
            <a href="../fun/Result.html">Results</a>
            <a href="../highlights/view.php">Highlights</a></li>

        <a href="change_password.php">Change Password</a> <!-- Assuming you have a logout page -->
    </div>
</div>

<div class="container">
    <h2>User Details</h2>
    <div>
        <label for="firstName">First Name:</label>
        <span><?php echo $userData['firstName']; ?></span>
    </div>
    <div>
        <label for="lastName">Last Name:</label>
        <span><?php echo $userData['lastName']; ?></span>
    </div>
    <div>
        <label for="sex">Sex:</label>
        <span><?php echo $userData['sex']; ?></span>
    </div>
    <div>
        <label for="country">Country:</label>
        <span><?php echo $userData['country']; ?></span>
    </div>
    <div>
        <label for="sports">Favorite Sport:</label>
        <span><?php echo $userData['sports']; ?></span>
    </div>
</div>

<footer>
    <img src="img/fu.png" alt="Footer Logo" width="80">
</footer>

</body>
</html>
