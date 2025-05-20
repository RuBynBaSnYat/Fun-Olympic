<?php
// index.php - Displaying games and associated videos

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "olympic";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/// Function to get all games
function getGames() {
    global $conn;
    $sql = "SELECT * FROM games";
    $result = $conn->query($sql);
    $games = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $games[] = $row;
        }
    }
    return $games;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Games</title>
</head>
<body>

<h2>Games List</h2>
<?php
$games = getGames();
foreach ($games as $game) {
    echo "<div>";
    echo "<h3>{$game['title']}</h3>";
    echo "<img src='{$game['thumbnail']}' alt='Thumbnail'>";
    echo "<p>Schedule: {$game['schedule']}</p>";
    echo "<p>Video Title: {$game['video_title']}</p>";
    echo "<p>Video Description: {$game['video_description']}</p>";
    echo '<iframe width="560" height="315" src="' . $game['video_link'] . '" frameborder="0" allowfullscreen></iframe>';
    echo "</div>";
}
?>

</body>
</html>