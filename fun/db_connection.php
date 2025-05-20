<?php
$servername = "localhost"; // Change to your MySQL server name if different
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password if set
$dbname = "olympic"; // Change to your desired database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
