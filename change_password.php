<?php
session_start();

// Include the database connection file
include('db_connection.php');

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_email'])) {
    header("Location: log.php");
    exit();
}

// Check if the form is submitted for changing the password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    // Retrieve user email from session
    $userEmail = $_SESSION['user_email'];

    // Retrieve hashed password from the database based on the user email
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $userData = $result->fetch_assoc();

        // Verify the current password
        if (password_verify($currentPassword, $userData['password'])) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $updateStmt->bind_param("ss", $hashedPassword, $userEmail);

            if ($updateStmt->execute()) {
                $successMessage = "Password updated successfully.";
            } else {
                $errorMessage = "Error updating password.";
            }

            // Close the update statement
            $updateStmt->close();
        } else {
            $errorMessage = "Current password is incorrect.";
        }
    } else {
        $errorMessage = "User not found.";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Include your CSS file -->
<style>
    /* Add your CSS styles for the change password page here */

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

.container label {
    font-weight: bold;
}

.container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.container button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.container button[type="submit"]:hover {
    background-color: #45a049;
}

.success-message {
    color: green;
}

.error-message {
    color: red;
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
        <a href="change_password.php">Change Password</a> <!-- Assuming you have a logout page -->
    </div>
</div>

<div class="container">
    <h2>Change Password</h2>
    <form action="change_password.php" method="post">
        <label for="currentPassword">Current Password:</label>
        <input type="password" id="currentPassword" name="currentPassword" required>
        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>
        <button type="submit">Change Password</button>
    </form>

    <?php if (isset($successMessage)): ?>
        <p class="success-message"><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <?php if (isset($errorMessage)): ?>
        <p class="error-message"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
</div>

<footer>
<img src="img/fu.png" alt="Footer Logo" width="80">
</footer>

</body>
</html>
