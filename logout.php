<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page after logout with JavaScript alert
echo "<script>alert('Logged out successfully.'); window.location.href='welcome.php';</script>";
exit();
?>
