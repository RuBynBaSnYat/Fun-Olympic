📑 FunOlympics Web Application
🔰 Project Title
FunOlympics – A Sports Event Web Platform

📝 Introduction
FunOlympics is a fully functional sports-themed web application developed using PHP, JavaScript, HTML, and CSS. The platform simulates an online Olympic environment where users can register, watch sports videos, interact via likes and comments, and stay updated on match schedules and news. It also provides an admin dashboard to manage users, content, and media efficiently.

🎯 Objectives
1. To develop a user-friendly sports event website
2. To allow admins to manage videos, user status, and match schedules
3. To provide users with engaging features like video interaction and news reading
4. To implement secure user authentication and password recovery
5. To use PHPMailer for email functionalities like password resets

🔧 Technologies Used
Technology	Purpose
1. HTML/CSS	Frontend Design
2. JavaScript	Client-side Interactions
3. PHP	Backend Logic
4. MySQL	Database Management
5. PHPMailer	Sending emails (e.g., forgot password)
6. XAMPP	Local Development Server

📁 Folder Structure
1. database/
a. Contains all SQL files
b. Used to set up required databases and tables in phpMyAdmin

2. admin/
a. Admin login and registration
b. Admin dashboard
c. Add/Edit/Delete videos
d. Block/Unblock users
e. View user status

3. fun/
a. User registration and login
b. Watch videos uploaded by admin
c. Like and comment on videos
d. Delete own comments
e. Change and reset password
f. View news articles and match schedules

4. hello/
a. Handles backend operations:
b. Add/Edit/Delete videos
c. Add/Delete comments
d. Edit/Delete match schedules

5. highlights/
a. Add and delete video highlights of matches/events

6. PHPMailer/
Integrated library for sending emails

Used for password recovery and other notifications

🔐 Security Features
Password hashing for user credentials

PHPMailer for secure password reset

Admin controls to block/unblock users

🧪 Testing & Deployment
The project was tested using the XAMPP environment. Apache and MySQL servers were run locally, and phpMyAdmin was used to manage the database. All functionalities like login, video handling, and comment interaction were tested in various user roles.

📌 How to Run the Project Locally

a. Install XAMPP and start Apache & MySQL.
b. Place the project folder in C:\xampp\htdocs.
c. Create a database in phpMyAdmin and import the SQL files from the database/ folder.
d. Configure PHPMailer with your SMTP credentials (if needed).

Open your browser and go to:
a. Admin Panel: http://localhost/admin
b. User Interface: http://localhost/fun

📈 Future Enhancements
a. Real-time video streaming support
b. Live chat during matches
c. Admin analytics dashboard
d. Enhanced mobile responsiveness
e. Two-factor authentication

👨‍💻 Developer
This project was developed as a part of a web development learning journey to demonstrate full-stack capabilities using PHP.
