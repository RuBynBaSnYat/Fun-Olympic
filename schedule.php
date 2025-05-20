<?php
session_start();

// Include database connection file
include_once "db_connection.php";

// Check if the user is logged in and is an admin, otherwise redirect to login page
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: sports.php");
    exit();
}

// Fetch events from the database
$sql = "SELECT * FROM schedule";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Check if delete button is clicked
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $eventIdToDelete = $_GET['id'];
    // Delete event from the database
    $sql = "DELETE FROM schedule WHERE id = $eventIdToDelete";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to schedule.php after deletion
        header("Location: schedule.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Check if add event form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $sport = $_POST['sport'];
    $venue = $_POST['venue'];
    
    // Insert event into database
    $sql = "INSERT INTO schedule (event_date, event_time, sport, venue) VALUES ('$date', '$time', '$sport', '$venue')";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to schedule.php after adding event
        header("Location: schedule.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympics 2024 Schedule</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Additional styles if needed -->
    <style>
        
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            /* Add more styles as needed */
        }
        .schedule-table th, .schedule-table td {
            border: 1px solid #ccc;
            padding: 10px;
            /* Add more styles as needed */
        }
        */
    </style>
</head>
<body>
    <div class="navbar">
        <!-- Navbar code (if you have a common navbar) -->
    </div>
    <div class="container">
        <h1>Olympics 2024 Schedule</h1>
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Sport</th>
                    <th>Venue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo date('M j, Y', strtotime($event['event_date'])); ?></td>
                        <td><?php echo date('h:i A', strtotime($event['event_time'])); ?></td>
                        <td><?php echo $event['sport']; ?></td>
                        <td><?php echo $event['venue']; ?></td>
                        <td>
                            <a href="?delete=true&id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Add New Event</h2>
        <form method="post">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
            <label for="sport">Sport:</label>
            <input type="text" id="sport" name="sport" required>
            <label for="venue">Venue:</label>
            <input type="text" id="venue" name="venue" required>
            <button type="submit">Add Event</button>
        </form>
    </div>
    <div class="footer">
        <!-- Footer code (if you have a common footer) -->
    </div>
</body>
</html>
