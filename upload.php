<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    // $price = $_POST['price'];

    // Ensure the uploads directory exists
    $uploads_dir = __DIR__ . "/uploads"; // Changed DIR to __DIR__
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    $file_path = $uploads_dir . "/" . basename($_FILES["file"]["name"]);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        $sql = "INSERT INTO notes (user_id, title, description, file_path) VALUES ('$user_id', '$title', '$description', '$file_path')";

        if ($conn->query($sql) === TRUE) {
            $message = "Note uploaded successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Error uploading file";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Note | HamroNotes</title>
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
                    <li><a href="#contact">Contact</a></li>
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

    
    <main class="upload-container">
        <h2>Upload Note</h2>
        <div class="message">
            <?php
            if (isset($message)) {
                echo htmlspecialchars($message);
            }
            ?>
        </div>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
            </div> -->
            <div class="form-group">
                <label for="file">File:</label>
                <input type="file" id="file" name="file" class="form-control" required>
            </div>
            <div class="form-btn">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 HamroNotes</p>
    </footer>

    <script>
        const hamburgerToggle = document.querySelector('.hamburger-toggle');
    const navLinks = document.getElementById('nav-links');

    if (hamburgerToggle && navLinks) {
        hamburgerToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
    </script>

    <script src="script.js"></script>
</body>
</html>