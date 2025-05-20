<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* Your CSS styles */
        /* General CSS styles */
       /* General CSS styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    background-image: url(s.jpg);
}

.container {
    max-width: 1000px; /* Increased max-width for better spacing */
    margin: 0 auto;
    padding: 10px;
    position: relative;
    z-index: 1;
    display: flex; /* Use flexbox to display cards horizontally */
    flex-wrap: wrap; /* Allow cards to wrap to the next line */
    justify-content: space-between; /* Distribute cards evenly */
    margin-top:100px;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
    margin-top:60px;
    width: calc(33.33% - 20px); /* Adjusted width to fit three cards in a row */
    max-width: 300px; /* Maximum width of each card */
    box-sizing: border-box; /* Include padding and border in the width calculation */
    flex: 1 0 auto; /* Allow cards to grow and shrink within the flex container */
    transition: transform 0.3s ease-in-out;
}

@media (max-width: 768px) {
    .card {
        width: calc(50% - 20px); /* Adjusted width for smaller screens to fit two cards in a row */
    }
}

@media (max-width: 480px) {
    .card {
        width: calc(100% - 20px); /* Adjusted width for smaller screens to fit one card per row */
    }
}

.card:hover {
    transform: translateY(-5px);
}

.card img {
    max-width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
}

.card h2 {
    margin-top: 0;
    font-size: 24px;
    color: #333;
}

.card p {
    color: #666;
}

.action-btns {
    display: flex;
    justify-content: flex-end;
    margin-top: 10px;
}

.action-btns button {
    margin-left: 10px;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.action-btns button:hover {
    background-color: #ddd;
}

#addForm,
#updateForm {
    margin-bottom: 20px;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    position: relative;
    z-index: 1; /* Ensure the form is above the blurred background */
}

#addForm:hover,
#updateForm:hover {
    transform: translateY(-5px);
}

#addForm input[type="text"],
#addForm textarea,
#addForm input[type="file"],
#addForm input[type="submit"],
#updateForm input[type="text"],
#updateForm textarea,
#updateForm input[type="file"],
#updateForm input[type="submit"] {
    width: calc(100% - 20px); /* Adjusted width */
    margin-bottom: 10px;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    margin-left: 10px; /* Added margin for better spacing */
}

#addForm input[type="submit"],
#updateForm input[type="submit"] {
    width: auto; /* Adjusted width */
    margin-left: 0; /* Remove margin to align submit button */
}

#addForm input[type="submit"],
#addForm input[type="submit"]:hover,
#updateForm input[type="submit"],
#updateForm input[type="submit"]:hover {
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    padding: 10px 20px; /* Adjusted padding for better button appearance */
    margin-top: 10px; /* Added margin for better spacing */
}

#addForm input[type="submit"]:hover,
#updateForm input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Adjustments for textareas */
#addForm textarea,
#updateForm textarea {
    resize: vertical; /* Allow vertical resizing of textarea */
    min-height: 100px; /* Set a minimum height */
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
<div class="navbar">
        <div class="navbar-logo">
            <img src="../img/fu.png" alt="Logo">
        </div>
        <div class="navbar-menu">
       
            <ul>
                <li><a href="../admin_dashboard.php">Home</a></li>
                <li><a href="../../highlights/admin_panel.php">Upload Highlights</a></li>
                <li><a href="../../hello/admin_panel.php">Add/Upload live</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <h1>Welcome, Admin! You can manage Schedule here.</h1>
        
        <!-- Form for adding a new sport -->
        <form id="addForm" action="add_sport.php" method="post" enctype="multipart/form-data">
            <h2>Add New Schedule</h2>
            <input type="text" name="sport_name" placeholder="Sport Name" required>
            <textarea name="sport_description" rows="4" placeholder="Description" required></textarea>
            <input type="text" name="sport_date" placeholder="Date (YYYY-MM-DD)" required>
            <input type="text" name="sport_venue" placeholder="Venue" required>
            <input type="file" name="sport_image" accept="image/*">
            <input type="submit" value="Add Sport">
        </form>

        <!-- Displaying existing sports -->
        <h2>Existing Schedule</h2>
        <?php
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

        // Query to fetch existing sports
        $sql = "SELECT * FROM sports";
        $result = $conn->query($sql);

        // Display sports
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="' . $row["image_path"] . '" alt="' . $row["name"] . '">';
                echo '<h2>' . $row["name"] . '</h2>';
                echo '<p><strong>Date:</strong> ' . $row["date"] . '</p>';
                echo '<p><strong>Venue:</strong> ' . $row["venue"] . '</p>';
                echo '<p><strong>Description:</strong> ' . $row["description"] . '</p>';
                // Action buttons for update and delete
                echo '<div class="action-btns">';
                echo '<button onclick="showUpdateForm(' . $row["id"] . ', \'' . $row["name"] . '\', \'' . $row["description"] . '\')">Update</button>';
                echo '<button onclick="confirmDelete(' . $row["id"] . ')">Delete</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No sports found.";
        }

        $conn->close();
        ?>

        <!-- Update form (initially hidden) -->
        <div id="updateForm" style="display: none;">
            <h2>Update Schedule</h2>
            <form action="update_sport.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="update_sport_id" name="update_sport_id">
                <input type="text" id="new_sport_name" name="new_sport_name" placeholder="New Sport Name" required>
                <textarea id="new_sport_description" name="new_sport_description" rows="4" placeholder="New Description" required></textarea>
                <input type="text" id="new_sport_date" name="new_sport_date" placeholder="New Date (YYYY-MM-DD)" required>
                <input type="text" id="new_sport_venue" name="new_sport_venue" placeholder="New Venue" required>
                <input type="file" name="new_sport_image" accept="image/*">
                <input type="submit" value="Update Sport">
            </form>
        </div>

        <!-- JavaScript for delete confirmation and update form -->
        <script>
            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete this sport?")) {
                    // If user confirms, redirect to delete_sport.php with the sport ID
                    window.location.href = "delete_sport.php?id=" + id;
                }
            }

            function showUpdateForm(id, name, description) {
                // Fill the update form fields with existing data
                document.getElementById("update_sport_id").value = id;
                document.getElementById("new_sport_name").value = name;
                document.getElementById("new_sport_description").value = description;
                // Show the update form
                document.getElementById("updateForm").style.display = "block";
            }
        </script>
    </div>
</body>
</html>
