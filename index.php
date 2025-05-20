<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Olympics</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav id="navbar">
        <!-- Replace "path/to/your/logo.png" with the actual path to your logo image -->
        <div style="float: left;">
            <img src="img/fu.png" alt="Logo" style="height: 70px; padding-left:10px;">
        </div>
        <div style="text-align: center;">FUN OLYMPICS 2024</div>
        <div style="text-align: right;">
            <a href="#home"> |&#127968;  Home</a> 
             <a href="#news"> |&#128240;  News</a> 
            <a href="#schedule">|&#128197;  Schedule</a> 
            <a href="#highlights">|&#127909;  Highlights</a> 
            <a href="#about">|👥  About Us</a> 
            <a href="#contact"> |&#128383;  Contact Us</a>
        </div>
    </nav>
    <div style="clear: both;"></div>

    <!-- Introduction Section -->
   <section id="home">
    <video autoplay muted loop id="homeVideo" style="width: 100%; height: 500px; object-fit: cover;">
        <source src="img/Oly.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div id="homeContent" style="position: absolute; top: 0; width: 100%; height: 500px; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white;">
        <h2>WELCOME TO FUN OlYMPICS 2024</h2>
        <p>Welcome to our Sports Website - your go-to source for all sports news, schedules, and event updates!</p>
     
    <div>GET START WITH:</div>
    <div class="button-container">
        <button class="btn" onclick="redirectToLogin()">Login</button>
        <button class="btn" onclick="redirectToRegistration()">Registration</button>
    </div>

    </div>
</section>

    <!-- News Section -->
<section id="news">
        <h2>News</h2>
        <div class="news-article">
            <div class="article">
                <img src="img/d.jpg" alt="News Image">
                <div class="article-text">
                    <h3>Exciting Match Recap</h3>
                    <p>Read about the thrilling match between Team A and Team B, with dramatic highlights and expert analysis.</p>
                    <a href="log.php" class="read-more">Read More</a>
                </div>
            </div>
            <div class="article">
                <img src="img/s.jpg" alt="News Image">
                <div class="article-text">
                    <h3>New Player Signing</h3>
                    <p>Learn about the latest addition to Team X and how this acquisition will impact the upcoming season.</p>
                    <a href="log.php" class="read-more">Read More</a>
                </div>
            </div>
            <div class="article">
                <img src="img/R.jpg" alt="News Image">
                <div class="article-text">
                    <h3>Upcoming Tournament</h3>
                    <p>Get the inside scoop on the highly anticipated tournament set to take place next month, featuring top teams from around the world.</p>
                    <a href="log.php" class="read-more">Read More</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Schedule Section -->
 <section id="schedule">
        <h2>Schedule</h2>
        <div class="event-container">
            <div class="event">
                <span class="icon">⚽</span>
                <h3>Event 1</h3>
                <p>Date: January 1, 2025</p>
                <p>Time: 10:00 AM - 12:00 PM</p>
                <p>Location: Stadium Name</p>
            
            </div>
            <div class="event">
                <span class="icon">🏀</span>
                <h3>Event 2</h3>
                <p>Date: January 2, 2025</p>
                <p>Time: 3:00 PM - 5:00 PM</p>
                <p>Location: Arena Name</p>
                
            </div>
            <div class="event">
                <span class="icon">🎾</span>
                <h3>Event 3</h3>
                <p>Date: January 3, 2025</p>
                <p>Time: 6:00 PM - 8:00 PM</p>
                <p>Location: Tennis Court</p>
                
            </div>
                        <div class="event">
                <span class="icon">🎾</span>
                <h3>Event 3</h3>
                <p>Date: January 3, 2025</p>
                <p>Time: 6:00 PM - 8:00 PM</p>
                <p>Location: Tennis Court</p>
               
            </div>
 <div class="event">
                <span class="icon">🏀</span>
                <h3>Event 2</h3>
                <p>Date: January 2, 2025</p>
                <p>Time: 3:00 PM - 5:00 PM</p>
                <p>Location: Arena Name</p>
               
            </div>
            <!-- Add more events as needed -->
        </div>
         </div>
        <div class="button-container">
        <a href="log.php"><button class="details-btn">More Details</button></a>

        </div>

    </section>

  
 <!-- Highlights Section -- Assuming it's similar to News -->
    <section id="highlights">
    <h2>Highlights</h2>
    <p>Game highlights and key moments...</p>
    
    <div class="video-container">
        <!-- Replace the URLs below with your YouTube video URLs -->
        <h1>Nepal vs India</h1>
        <iframe width="360" height="200" src="https://www.youtube.com/embed/EBbtUQ7X7jA?si=AQldwuHLY5t5pkIi" frameborder="0" allowfullscreen></iframe>
    </div>
    

    <div class="video-container">
        <iframe width="360" height="200" src="https://www.youtube.com/embed/4CFmnVAw5bc?si=e0jHDz0LsYUVJ3xS" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <div class="video-container">
        <iframe width="360" height="200" src="https://www.youtube.com/embed/9WUQL03eNTM?si=Uj9IP_VuCQSpX7_2" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="video-container">
        <iframe width="360" height="200" src="https://www.youtube.com/embed/pSQWMaQgMQs?si=G5oBVA3iwOce6pLe" frameborder="0" allowfullscreen></iframe>
    </div>
<div class="video-container">
        <iframe width="360" height="200" src="https://www.youtube.com/embed/CZsH46Ek2ao?si=Wzkf5G2KNmBXNY-Z" frameborder="0" allowfullscreen></iframe>
    </div>
     <div class="watch-more-btn">
        <a href="log.php">Watch More</a>
    </div>

</section>

 <section id="about">
    <h2>About Us</h2>
    <p>Our dynamic team consists of six dedicated professionals, each an expert in their own domain, collaborating to bring our vision into reality. The group includes two frontend developers, focused on designing intuitive and engaging user interfaces; two backend developers, who ensure our applications' seamless functionality; one quality assurance specialist, upholding our commitment to superior quality; and a project manager, who steers our project towards success with strategic oversight.
    We merge creativity with technology to forge solutions that are both groundbreaking and meaningful. Our diverse skill sets allow us to address challenges comprehensively, delivering outcomes that are both effective and innovative. Join us on our path of creativity, teamwork, and distinction..</p>
    <p>Our mission is to provide live match watching website for 10000 for user with user friendly.</p>
    
    <!-- Team Members -->
    <div class="team-member">
        <img src="img/m1.png" alt="Rubyn Basnyat">
        <h3>Rubyn Basnyat</h3>
        <p>Project Manager</p>
    </div>

    <div class="team-member">
        <img src="img/fe1.png" alt="Shisam Gyawali">
        <h3>Shisam Gyawali</h3>
        <p>Forntend Developer</p>
    </div>
    <div class="team-member">
        <img src="img/fe3.png" alt="Kamala Basnyat">
        <h3>Kamala Basnyat</h3>
        <p>Forntend Developer</p>
    </div>

    <div class="team-member">
        <img src="img/m2.png" alt="Pawan Basnyat">
        <h3>Pawan Basnyat</h3>
        <p>Backend Developer</p>
    </div>

    <div class="team-member">
        <img src="img/m3.png" alt="Unik Basnyat">
        <h3>Unik Basnyat</h3>
        <p>Backend Developer</p>
    </div>
     <div class="team-member">
        <img src="img/fe2.png" alt="Puza Akauliya">
        <h3>Puza Akauliya</h3>
        <p>QA</p>
    </div>

</section>
    <!-- Contact Us Section -->
   <section id="contact">
    <h2>Contact Us</h2>
    <p>Get in touch with us...</p>
    <form class="contact-form" action="#" method="post">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <input type="submit" value="Send Message">
    </form>
</section>
<footer>
    <div class="footer-text">
         <img src="img/fu.png" alt="Footer Logo" width="80">
        <p>&copy; 2024 FUN OLYMPIC. All rights reserved.</p>
   
</footer>
    <script>
        let lastScrollTop = 0; // Variable to store the last scroll position
        
        window.addEventListener("scroll", function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop; // Get current scroll position
            if (currentScroll > lastScrollTop) {
                document.getElementById("navbar").classList.add("hidden"); // Add hidden class when scrolling down
            } else {
                document.getElementById("navbar").classList.remove("hidden"); // Remove hidden class when scrolling up
            }
            lastScrollTop = currentScroll; // Update last scroll position
        });
         function redirectToLogin() {
        window.location.href = 'log.php'; // Change the URL to your login page
    }

    function redirectToRegistration() {
        window.location.href = 'reg.php'; // Change the URL to your registration page
    }
    </script>
</body>
</html>
