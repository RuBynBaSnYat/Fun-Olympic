<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "olympic";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create games table
$sql_create_table = "CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    video_link VARCHAR(255),
    thumbnail_link VARCHAR(255)
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Table 'games' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Function to fetch all games
function getGames($conn) {
    $sql = "SELECT * FROM games";
    $result = $conn->query($sql);
    $games = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $games[] = $row;
        }
    }
    return $games;
}

// Initialize $games variable
$games = [];

// Read operation
$games = getGames($conn);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Games</title>
    <style>
        /* Form styling */
        form {
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Button styling */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Thumbnail image styling */
        img.thumbnail {
            max-width: 100px;
            max-height: 100px;
            transition: transform 0.3s;
        }

        img.thumbnail:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<h2>Add New Game</h2>
<form method="post" action="" enctype="multipart/form-data">
    Title: <input type="text" name="title"><br>
    Description: <textarea name="description"></textarea><br>
    Video Link: <input type="text" name="video_link"><br>
    Thumbnail Image: <input type="file" name="thumbnail_image"><br>
    <input type="submit" name="submit" value="Add Game">
</form>

<h2>Manage Games</h2>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Video Link</th>
        <th>Thumbnail</th>
        <th>Action</th>
    </tr>
    <?php foreach ($games as $game) { ?>
        <tr>
            <td><?php echo $game['title']; ?></td>
            <td><?php echo $game['description']; ?></td>
            <td><?php echo $game['video_link']; ?></td>
            <td><img src="<?php echo $game['thumbnail_link']; ?>" alt="Thumbnail" style="max-width: 100px; max-height: 100px;"></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $game['id']; ?>">
                    <input type="submit" name="update" value="Update">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
