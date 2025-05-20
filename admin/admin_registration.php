<?php
// Handle admin registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include('db_connection.php');

    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    // You may include more fields like name, email, etc., depending on your registration form

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Set the role to 'admin'
    $role = 'admin';

    // Prepare and execute the SQL statement to insert admin data into the database
    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    
    if ($stmt->execute()) {
        // Registration successful, redirect to login page or admin dashboard
        header("Location: log.php"); // Redirect to login page
        exit();
    } else {
        // Registration failed, handle the error (e.g., display an error message)
        $error = "Registration failed. Please try again.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
</head>
<body>
    <h2>Admin Registration</h2>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>
        <!-- Add more fields as needed for admin registration -->
        <input type="submit" value="Register">
    </form>
</body>
</html>
