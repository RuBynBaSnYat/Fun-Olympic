f<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            background-image: url('img/Wel.jpg');
            font-family: Arial, sans-serif;
            background-color: lightblue;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        fieldset {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        legend {
            padding-top:20px;
            font-size: 20px;
            color: #333;
            font color: White;
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #4CAF50;
            margin-top: 10px;
        }

        .error-message {
            color: #ff0000;
            margin-top: 10px;
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

    </style>
</head>
<body>
<?php
include('db_connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function generateToken() {
    return bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];

    // Validate the email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email exists in the database
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $stmtCheckEmail = $conn->prepare($checkEmailQuery);
        $stmtCheckEmail->bind_param("s", $email);
        $stmtCheckEmail->execute();
        $resultCheckEmail = $stmtCheckEmail->get_result();

        if ($resultCheckEmail->num_rows > 0) {
            
            $token = generateToken();

            // Calculate expiration time (10 minutes from now)
            $expirationTime = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Update the user's record with the token and expiration time
            $updateQuery = "UPDATE users SET reset_token = ?, token_expiration = ? WHERE email = ?";
            $stmtUpdateToken = $conn->prepare($updateQuery);
            $stmtUpdateToken->bind_param("sss", $token, $expirationTime, $email);
            $stmtUpdateToken->execute();

            // Set up PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pujabasnyat1991@gmail.com'; 
            $mail->Password = 'aqgg qqvu rmfm favt'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            
            $headers = "11pawanbasnyat11@gail.com\r\n";
            $headers .= "11pawanbasnyat11@gmail.com\r\n"; 
            $headers .= "11pawanbasnyat11@gmail.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Send an email with the reset link containing the token
            $resetLink = "http://localhost/fun/reset_password.php?token=$token";
            $subject = "Password Reset";
            $message = "Click the following link to reset your password: $resetLink";

           
            $mail->setFrom('11pawanbasnyat11@gmail.com');
            $mail->addReplyTo('11pawanbasnyat11@gmail.com'); 
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;

            
            $mail->SMTPDebug = 0;

            try {
                $mail->send();
                echo "Password reset email sent to " . $email;
            } catch (Exception $e) {
                echo "Error sending password reset email. Please check your email settings. Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Email not found.";
        }

        $stmtCheckEmail->close();
    } else {
        echo "Invalid email address.";
    }
}

$conn->close();
?>
<div class="navbar">
    <div class="navbar-logo">
        <img src="img/fu.png" alt="Logo">
    </div>
    <div class="navbar-menu">
        <ul>
            <li><a href="log.php">Home</a></li>
            <li><a href="../fun/sports/user_sports.php">Schedule</a></li>
            <li><a href="../newsfeed/index.php">News</a></li>
            <li><a href="../fun/Result.html">Results</a></li>
            <li><a href="../highlights/view.php">Highlights</a></li>
            <li><a href="../fun/user_details.php">User Details</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<fieldset>
    <legend>Password Reset</legend>
    <form id="reset-form" method="post" action="forget_password.php">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Reset Password</button>
    </form>
</fieldset>
</body>
</html>