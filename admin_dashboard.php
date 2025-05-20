<?php
session_start();

// Check if the user is logged in and has the admin role, otherwise redirect to login page
if (!isset($_SESSION["user_email"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: log.php");
    exit();
}

// Include the necessary files
include('db_connection.php');
include('admin_functions.php');

// Get total number of non-admin users
$totalUsers = getTotalUsers($conn);

// Get list of users
$users = getUsers($conn);

// Process block/unblock actions if requested
if (isset($_GET['action']) && isset($_GET['email'])) {
    $userEmail = $_GET['email'];
    $action = $_GET['action'];

    if ($action == 'block') {
        blockUser($conn, $userEmail);
    } elseif ($action == 'unblock') {
        unblockUser($conn, $userEmail);
    }
}

// Refresh user list after block/unblock action
$users = getUsers($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_styles.css">
    <style>
           body {
            background-image: url('dd.jpg'); /* Replace 'background_image.jpg' with your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif; /* Add font-family for the body */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }
     
        .logo {
            margin-bottom: 20px; /* Add margin at the bottom of the logo */
        }

        .logo img {
            width: 50px; /* Adjust logo size as needed */
            margin-right: 10px; /* Add margin to the right of the logo */
            vertical-align: middle; /* Align the logo vertically */
        }

        .logo h2 {
            display: inline-block; /* Display the heading inline with the logo */
            font-size: 20px; /* Adjust font size as needed */
            vertical-align: middle; /* Align the heading vertically */
        }

        .navigation {
            margin-top: 20px;
        }

        .navigation ul {
            list-style-type: none;
            padding: 0;
        }

        .navigation ul li {
            margin-bottom: 10px;
        }

        .navigation ul li a {
            text-decoration: none;
            color: White;
            display: block;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navigation ul li a:hover {
            background-color: Green;
        }

        .navigation form {
            margin-top: 20px;
        }

        .navigation button {
            background-color: Green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .navigation button:hover {
            background-color: #d32f2f;
        }

        /* Added CSS for the slide feature */
        .total-users-container {
            overflow: hidden;
            transition: max-height 0.3s ease;
            max-height: 0;
        }

        .total-users-container.show {
            max-height: 1000px; /* Adjust according to your content */
            transition: max-height 0.3s ease;
        }
        /* Add hover effect for total users link */
.total-users-link:hover {
    background-color: Green;
    cursor: pointer;
}

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <img src="img/fu.png" alt="Logo">
            <h2>Fun Olympics 2024</h2>
        </div>        
        <div class="navigation">
            <ul>
                <li><a href="../fun/admin_dashboard.php">Admin Dashboard</a></li>
                <li onclick="toggleTotalUsers()" class="total-users-link">Total Users: <?php echo $totalUsers; ?></li> 

                <li><a href="../hello/admin_panel.php">Add Games And Upload Live</a></li>
                <li><a href="../fun/sports/admin_sports.php">Manage Schedule</a></li>
                <li><a href="../highlights/admin_panel.php">Manage Highlights</a></li>

                
                <!-- Add more navigation links as needed -->
            </ul>
            <form action="admin_logout.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    <div class="main-content">
        <h1>Admin Dashboard</h1>
        <div class="user-list">
            <!-- Updated the class to total-users-container -->
            <div class="total-users-container" id="total-users-container">
                <?php if (count($users) > 0): ?>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Last Active</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['firstName']; ?></td>
                                <td><?php echo $user['lastName']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo ($user['active'] == 1) ? 'Active' : 'Inactive'; ?></td>
                                <td><?php echo $user['lastActive']; ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                                    <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
                                    <?php if ($user['block_status'] == 1): ?>
                                        <a href="admin_dashboard.php?action=block&email=<?php echo $user['email']; ?>">Block</a>
                                    <?php else: ?>
                                        <a href="admin_dashboard.php?action=unblock&email=<?php echo $user['email']; ?>">Unblock</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleTotalUsers() {
            var totalUsersContainer = document.getElementById("total-users-container");
            totalUsersContainer.classList.toggle("show");
        }
    </script>
</body>
</html>
