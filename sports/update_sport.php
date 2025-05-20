<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportsdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data for update (if submitted)
if (isset($_POST['update_sport_id'])) {
    $sport_id = $_POST['update_sport_id'];
    $new_sport_name = $_POST['new_sport_name'];
    $new_sport_description = $_POST['new_sport_description'];
    $new_sport_date = $_POST['new_sport_date'];
    $new_sport_venue = $_POST['new_sport_venue'];

    // Handle image upload
    $target_dir = "images/"; // Directory where the image will be stored
    $target_file = $target_dir . basename($_FILES["new_sport_image"]["name"]); // Path of the uploaded file
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["new_sport_image"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['update_message'] = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["new_sport_image"]["size"] > 500000) {
        $_SESSION['update_message'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, array("jpg", "png", "jpeg", "gif"))) {
        $_SESSION['update_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['update_message'] = "Sorry, your file was not uploaded.";
    } else {
        // If everything is okay, try to upload the file
        if (move_uploaded_file($_FILES["new_sport_image"]["tmp_name"], $target_file)) {
            $_SESSION['update_message'] = "The file " . basename($_FILES["new_sport_image"]["name"]) . " has been uploaded.";
        } else {
            $_SESSION['update_message'] = "Sorry, there was an error uploading your file.";
        }
    }

    // Update sport in the database if image upload was successful
    if ($uploadOk == 1) {
        $sql = "UPDATE sports SET name=?, description=?, date=?, venue=?, image_path=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $new_sport_name, $new_sport_description, $new_sport_date, $new_sport_venue, $target_file, $sport_id);
        
        if ($stmt->execute()) {
            $_SESSION['update_message'] = "Sport updated successfully";
        } else {
            $_SESSION['update_message'] = "Error updating record: " . $conn->error;
        }

        $stmt->close();
    }
}

// Close connection
$conn->close();

// Redirect back to admin_sports.php
header("Location: admin_sports.php");
exit();
?>
