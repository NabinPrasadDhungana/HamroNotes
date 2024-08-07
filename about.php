<?php
session_start(); // Start the session at the beginning of the script
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | HamroNotes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-...your-integrity-hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
</head>
<body>
<header>
        <div class="container">
            <h1><a href="index.php">HamroNotes</a></h1>
            <nav>
                <div class="hamburger-menu" id="hamburger-menu">
                    <button class="hamburger-toggle" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <ul class="nav-links" id="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="notes.php">All Notes</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="upload.php">Upload Note</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="profile.php" class="user-icon" title="Profile"><i class="fas fa-user"></i></a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registration.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section id="about-us">
            <h2>About Us</h2>
            <div class="about-content">
                <p>Welcome to HamroNotes, your go-to platform for sharing notes. </p>

                <p> HamroNotes is a dynamic note-sharing platform where individuals can upload and share their valuable notes with the community. Users in need of specific notes can easily browse and download the required documents, making it a convenient resource for everyone. Whether you're looking to contribute your knowledge or seeking study materials, HamroNotes provides a seamless experience. Join HamroNotes today to enhance learning and collaboration through shared knowledge.</p>
                
                <h3>Our Story</h3>
                <p>HamroNotes was created by a team of passionate developers and designers who wanted to solve the challenges of note management. We started with a simple idea and turned it into a comprehensive solution for students, professionals, and anyone who wants to stay organized.</p>
                
                <h3>Our Team</h3>
                <p>Our team is dedicated to making HamroNotes the best it can be. We come from diverse backgrounds and bring a wealth of experience in software development, user experience design, and project management.</p>

                <h3>Contact Us</h3>
                <p>If you have any questions or feedback, feel free to reach out to us at <a href="index.php#contact">support@hamronotes.com</a>.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 HamroNotes. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const hamburgerToggle = document.querySelector('.hamburger-toggle');
        const navLinks = document.getElementById('nav-links');

        hamburgerToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    });
    </script>

    <script src="script.js">    </script>
</body>
</html>
