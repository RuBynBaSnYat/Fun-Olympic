<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        #sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
            background: #333;
            color: #fff;
            padding-top: 20px;
        }
        #sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        #sidebar h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        #sidebar ul li {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #sidebar ul li:hover {
            background-color: #555;
        }
        #content {
            margin-left: 250px;
            padding: 20px;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        #logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <h1>Admin Dashboard</h1>
        <ul>
            <li onclick="loadPage('user_status_page.php')">User Status</li>
            <li onclick="loadPage('upload_news_page.html')">Upload News</li>
            <li onclick="loadPage('upload_sports_page.html')">Upload Sports</li>
            <li onclick="loadPage('upload_results_page.html')">Upload Results</li>
            <li onclick="loadPage('upload_schedule_page.html')">Upload Schedule</li>
            <li onclick="loadPage('upload_video.php')">Upload Video</li>
        </ul>
        <button id="logout" class="button" onclick="logout()">Logout</button>
    </div>
    <div id="content">
        <!-- Content will be loaded here -->
    </div>

    <script>
        function loadPage(page) {
            // Load page content dynamically
            var contentDiv = document.getElementById('content');
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    contentDiv.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", page, true);
            xhttp.send();
        }

        function logout() {
            // Implement logout logic here
            alert("Logging out...");
        }
    </script>
</body>
</html>
