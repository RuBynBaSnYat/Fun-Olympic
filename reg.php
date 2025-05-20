<?php
// Include the database connection file
include('db_connection.php');

// Define variables to hold the password validation message and color
$passwordMessage = '';
$passwordColor = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $sex = $_POST['sex'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sports = $_POST['sports'];

    // Check if email already exists
    $check_email_query = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) {
        // Error executing the query
        $passwordMessage = "Error checking email: " . $stmt->error;
        $passwordColor = 'red';
    } else {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Email already exists
            $passwordMessage = 'Email already exists!';
            $passwordColor = 'red';
        } else {
            // Password validation
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password)) {
                $passwordMessage = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number!';
                $passwordColor = 'red';
            } else {
                // Hash the password before storing it
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Prepare and execute SQL statement to insert data into the users table
                $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, sex, country, email, password, sports) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $firstName, $lastName, $sex, $country, $email, $hashedPassword, $sports);

                if ($stmt->execute()) {
                    // Registration successful
                    echo '<script>alert("Registration successful!"); window.location.href = "log.php";</script>';
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
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Page</title>
<style>
    /* Your CSS styles */
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
        background-image: url('img/1.jpg');
        background-size: cover;
        background-position: center;
        color: white;
    }

    .password-message {
        margin-top: 10px;
        color: red;
    }

    .nav-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 10px 50px;
        box-sizing: border-box;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        transition: color 0.3s;
    }

    .nav-links a:hover {
        color: green;
    }

    .container {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
        max-width: 350px;
        margin: auto;
        margin-top: 40px;
        margin-bottom: 40px;
        margin-right: 80px;
        color: white;
        position: relative;
        height: auto;
        max-height: 700px; /* Adjusted height */
    }

    label {
        display: block;
        margin-bottom: 10px; /* Adjusted margin */
        font-size: 14px; /* Adjusted font size */
    }

    input[type="text"], input[type="email"], input[type="password"], select {
        width: 100%; /* Adjusted width */
        padding: 10px;
        margin: 5px 0;
        border: none;
        border-radius: 50px;
        background-color: #f8f8f8;
        color: black;
        font-size: 14px;
    }

    .password-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .password-toggle i {
        font-size: 20px;
    }

    .show-password-label {
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
    }

    .show-password-checkbox {
        margin-right: 5px;
    }

    .sex-options {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }

    .sex-options label {
        margin-right: 10px;
    }

    .btn {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        margin: 20px 0;
        border: none;
        cursor: pointer;
        width: 50%; /* Adjusted width */
        border-radius: 5px;
        display: block; /* Displayed as a block to place it on a new line */
        margin: auto; /* Centered the button */
    }

    .btn:hover {
        background-color: green;
    }

    .footer-text {
        text-align: center;
        padding: 20px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
    }

    .back-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        border: none;
        background: none;
        color: white;
        cursor: pointer;
        font-size: 24px;
    }

    .login-text {
        text-align: center;
        margin-top: 10px;
    }

    .login-text a {
        color: white;
        text-decoration: underline;
        cursor: pointer;
    }

    .login-text a:hover {
        color: green;
    }

    /* Ensure selected option is visible in dropdown */
    select {
        color: black; /* Set the color to black for the select element */
    }

    option {
        color: black; /* Set the color to black for the options */
    }

    /* Pop-up dialog box styles */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        color: white;
        border-radius: 10px;
        z-index: 9999;
    }

    .popup-content {
        text-align: center;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: white;
    }
</style>
</head>
<body>
<div class="nav-bar">
    <img src="img/fu.png" alt="Logo" style="width: 80px;">
    <h1>FUN OLYMPIC 2024</h1>
    <div class="nav-links">
        <a href="index.php">Home</a>
    </div>
</div>

<div class="container">
    <button class="back-btn" onclick="history.back()">←</button>
    <h2>Registration</h2>
    <form id="registrationForm" action="reg.php" method="post" onsubmit="return validateForm()">
        <!-- Your form fields -->
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" placeholder="First Name" required>

        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>

        <div class="sex-options">
            <label>Sex:</label>
            <input type="radio" id="male" name="sex" value="Male" required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="sex" value="Female" required>
            <label for="female">Female</label>
            <input type="radio" id="other" name="sex" value="Other" required>
            <label for="other">Other</label>
        </div>

        <label for="country">Country</label>
        <select id="country" name="country" required>
            <option value="" disabled selected>Select a country</option>
            <option value="usa">USA</option>
            <option value="canada">Canada</option>
            <option value="uk">UK</option>

            <!-- Add more countries as needed -->
        </select>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required>

        <label for="password">Password</label>
        <div class="password-container">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <span class="password-toggle" onclick="togglePasswordVisibility('password')"><i class="fa fa-eye"></i></span>
            <span id="passwordMessage" class="password-message"></span>
        </div>

        <label for="confirmPassword">Confirm Password</label>
        <div class="password-container">
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            <span class="password-toggle" onclick="togglePasswordVisibility('confirmPassword')"><i class="fa fa-eye"></i></span>
            <span id="confirmMessage" class="password-message"></span>
        </div>

        <label for="sports">Which sport do you like?</label>
        <select id="sports" name="sports" required>
            <option value="" disabled selected>Select a sport</option>
            <option value="football">Football</option>
            <option value="basketball">Basketball</option>
            <option value="tennis">Tennis</option>
            <option value="football">Vollball</option>
            <option value="basketball">Marathon</option>
            <option value="tennis">Javlin Throw</option>
            <option value="other">Other</option>
        </select>

        <div class="show-password-label">
            <input type="checkbox" id="showPasswordCheckbox">
            <label for="showPasswordCheckbox">Show Password</label>
        </div>

        <button type="submit" class="btn">Submit</button>

        <div class="login-text">
            Already have an account? <a href="log.php">Login</a>
        </div>
    </form>
</div>

<div class="footer-text">
    <p>&copy; 2024 FUN OLYMPIC. All rights reserved.</p>
</div>

<script>
// Your JavaScript code here

// Function to validate form fields
function validateForm() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    // Validate password criteria
    var passwordCriteriaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (!passwordCriteriaRegex.test(password)) {
        document.getElementById('passwordMessage').textContent = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number!';
        return false; // Prevent form submission
    }

    // Validate password and confirm password match
    if (password !== confirmPassword) {
        document.getElementById('confirmMessage').textContent = 'Passwords do not match.';
        return false; // Prevent form submission
    }

    // No validation errors, allow form submission
    return true;
}

// Function to toggle password visibility
// Function to toggle password visibility
// Function to toggle password visibility

// Function to toggle password visibility
function togglePasswordVisibility() {
    var passwordFields = document.querySelectorAll('input[type="password"]');
    var checkbox = document.getElementById('showPasswordCheckbox');

    passwordFields.forEach(function(field) {
        if (checkbox.checked) {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    });
}

// Event listener for the checkbox
document.getElementById('showPasswordCheckbox').addEventListener('change', function() {
    togglePasswordVisibility();
});

// Initial toggle
togglePasswordVisibility();
</script>
</body>
</html>
