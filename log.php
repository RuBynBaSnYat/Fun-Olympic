<?php
session_start();

// Include the database connection file
include('db_connection.php');

// Initialize login message variable
$loginMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email'];
    $password = $_POST['password'];

    // Retrieve user data from the database based on the provided email
    $stmt = $conn->prepare("SELECT id, email, password, role, block_status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the user is blocked
        if ($user['block_status'] == 1) {
            $loginMessage = "Your account has been blocked by the admin. Please contact support for assistance.";
        } else {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                // Check the user's role
                if ($user['role'] === 'admin') {
                    // If the user is an admin, redirect to admin dashboard
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    // If the user is not an admin, redirect to welcome page
                    header("Location: welcome.php");
                    exit();
                }
            } else {
                // Incorrect password
                $loginMessage = "Invalid email or password.";
            }
        }
    } else {
        // User not found
        $loginMessage = "Invalid email or password.";
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
    <title>Login Page</title>
    <link rel="stylesheet" href="login_styles.css">
</head>
<body>

<div class="nav-bar">
    <img src="img/fu.png" alt="Logo">
    <h1>FUN OLYMPIC 2024</h1>
    <div class="nav-links">
        <a href="index.php">Home</a>
    </div>
</div>

<div class="main-content">
    <div class="container">
        <form action="log.php" method="post">
            <label for="UserEmail">User Email</label>
            <input type="text" name="Email" placeholder="User Email" aria-label="Email" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" aria-label="Password" required>

            <button type="submit" class="btn">Login</button>
            <a href="forget_password.php" class="forgot">Forgot Password?</a>If you don't have account<a href="reg.php" class="forgot"> Register,Here?</a>
            
        </form>

        <?php if (!empty($loginMessage)): ?>
            <p><?php echo $loginMessage; ?></p>
        <?php endif; ?>
    </div>
</div>
<footer>
    <img src="img/fu.png" alt="Footer Logo" width="80">
</footer>

</body>
</html>
