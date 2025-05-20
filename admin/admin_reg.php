<?php
// Initialize $passwordMessage to an empty string to avoid undefined variable error
$passwordMessage = '';

// Include the database connection file
include('admin_db_connection.php');

// Define variables to hold the password validation message and color
$passwordColor = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Password validation
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password)) {
        $passwordMessage = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number!';
        $passwordColor = 'red';
    } else {
        // Check if the email already exists in the database
        $checkStmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Email already exists, display error message
            $passwordMessage = "Email '$email' has already been taken.";
            $passwordColor = 'red';
            // Close check statement
            $checkStmt->close();
        } else {
            // Email does not exist, proceed with registration
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute SQL statement to insert data into the admins table
            $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                // Registration successful
                $passwordMessage = 'Admin registration successful!';
                $passwordColor = 'green';
                // Redirect to login page after successful registration
                header("Location: admin_log.php");
                exit();
            } else {
                // Registration failed
                $passwordMessage = "Error: " . $stmt->error;
                $passwordColor = 'red';
            }

            // Close statement
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/R.jpg'); /* Replace 'your_image.jpg' with the path to your background image */
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
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        div {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
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

        .password-message {
            color: <?php echo $passwordColor; ?>;
        }
    </style>
    <script>
        function validateForm() {
            var passwordMessage = document.getElementById('passwordMessage').innerHTML;
            if (passwordMessage === "") {
                return true; // Form submission allowed
            } else {
                return false; // Form submission blocked
            }
        }
    </script>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <h2>Admin Registration</h2>
        <div><input type="text" name="username" placeholder="Username" required></div>
        <div><input type="email" name="email" placeholder="Email" required></div>
        <div><input type="password" name="password" placeholder="Password" required></div>
        <div><input type="password" name="confirmPassword" placeholder="Confirm Password" required></div>
        <div><input type="submit" value="Register"></div>
    </form>
    <div id="passwordMessage" class="password-message"><?php echo $passwordMessage; ?></div>
</body>
</html>
