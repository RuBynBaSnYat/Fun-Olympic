<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Articles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .article {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        .article img {
            max-width: 100%;
            border-radius: 5px;
        }
        .article h3 {
            margin-top: 0;
        }
        .article p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <h1>View Articles</h1>
    <?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "olympic";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch articles from the database
    $sql = "SELECT heading, paragraph, image_path FROM articles";
    $result = $conn->query($sql);

    // Display articles
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='article'>";
            echo "<h3>" . $row["heading"] . "</h3>";
            echo "<p>" . $row["paragraph"] . "</p>";
            echo "<img src='" . $row["image_path"] . "' alt='Article Image'>";
            echo "</div>";
        }
    } else {
        echo "No articles found.";
    }

    // Close database connection
    $conn->close();
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Articles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .article {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        .article img {
            max-width: 100%;
            border-radius: 5px;
        }
        .article h3 {
            margin-top: 0;
        }
        .article p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <h1>View Articles</h1>
    <?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "olympic";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch articles from the database
    $sql = "SELECT heading, paragraph, image_path FROM articles";
    $result = $conn->query($sql);

    // Display articles
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='article'>";
            echo "<h3>" . $row["heading"] . "</h3>";
            echo "<p>" . $row["paragraph"] . "</p>";
            echo "<img src='" . $row["image_path"] . "' alt='Article Image'>";
            echo "</div>";
        }
    } else {
        echo "No articles found.";
    }

    // Close database connection
    $conn->close();
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Articles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .article {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        .article img {
            max-width: 100%;
            border-radius: 5px;
        }
        .article h3 {
            margin-top: 0;
        }
        .article p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <h1>View Articles</h1>
    <?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "olympic";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch articles from the database
    $sql = "SELECT heading, paragraph, image_path FROM articles";
    $result = $conn->query($sql);

    // Display articles
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='article'>";
            echo "<h3>" . $row["heading"] . "</h3>";
            echo "<p>" . $row["paragraph"] . "</p>";
            echo "<img src='" . $row["image_path"] . "' alt='Article Image'>";
            echo "</div>";
        }
    } else {
        echo "No articles found.";
    }

    // Close database connection
    $conn->close();
    ?>
</body>
</html>
