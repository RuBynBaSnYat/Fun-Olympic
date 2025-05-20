<?php
// session_start();

// // Check if the user is logged in as admin, otherwise redirect to login page
// if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
//     header("Location: log.php");
//     exit();
// }

// Include the necessary files
include('db_connection.php');

// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "User ID not provided.";
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    // Update user details in database
    $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $firstName, $lastName, $email, $userId);

    
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.'); window.location.href = 'admin_dashboard.php';</script>";
        exit();
    } else {
        echo "Error updating user.";
    }
    
    

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="" method="post">
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $user['firstName']; ?>" required>

        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $user['lastName']; ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
