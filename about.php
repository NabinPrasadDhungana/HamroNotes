<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | HamroNotes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-...your-integrity-hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">HamroNotes</a></h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="notes.php">All Notes</a>
                <a href="about.php">About Us</a>
                <a href="contact.php">Contact</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="upload.php">Upload Note</a>
                    <a href="logout.php">Logout</a>
                    <a href="profile.php" class="user-icon" title="Profile"><i class="fas fa-user"></i></a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="registration.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <section id="about-us">
            <h2>About Us</h2>
            <div class="about-content">
                <p>Welcome to HamroNotes, your go-to platform for managing and sharing notes. Our mission is to provide an easy-to-use, reliable, and feature-rich platform for all your note-taking needs.</p>
                
                <h3>Our Story</h3>
                <p>HamroNotes was created by a team of passionate developers and designers who wanted to solve the challenges of note management. We started with a simple idea and turned it into a comprehensive solution for students, professionals, and anyone who wants to stay organized.</p>
                
                <h3>Our Team</h3>
                <p>Our team is dedicated to making HamroNotes the best it can be. We come from diverse backgrounds and bring a wealth of experience in software development, user experience design, and project management.</p>

                <h3>Contact Us</h3>
                <p>If you have any questions or feedback, feel free to reach out to us at <a href="mailto:support@hamronotes.com">support@hamronotes.com</a>.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 HamroNotes. All rights reserved.</p>
    </footer>
</body>
</html>