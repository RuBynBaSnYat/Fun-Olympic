<?php
// Include the database connection file
include('admin_db_connection.php');

// Initialize variables for login feedback
$loginMessage = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to retrieve admin data by email
    $stmt = $conn->prepare("SELECT id, email, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin exists and password is correct
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to admin panel
            session_start();
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_email'] = $row['email'];
            header("Location: admin_index.php");
            exit();
        } else {
            // Password is incorrect
            $loginMessage = "Incorrect password.";
        }
    } else {
        // Admin with provided email does not exist
        $loginMessage = "Admin with email '$email' does not exist.";
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('your_image.jpg'); /* Replace 'your_image.jpg' with the path to your background image */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }

        form {
            background-color: rgba(255, 255, 255, 0.8); /* Blurred background color */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            filter: blur; /* Apply blur effect */
        }

        div {
            margin-bottom: 15px;
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            opacity: 0.9;
        }

        .login-message {
            color: red;
        }
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Admin Login</h2>
        <div><input type="email" name="email" placeholder="Email" required></div>
        <div><input type="password" name="password" placeholder="Password" required></div>
        <div><input type="submit" value="Login"></div>
    </form>
    <div class="login-message"><?php echo $loginMessage; ?></div>
</body>
</html>
