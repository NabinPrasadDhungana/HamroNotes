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
    $price = $_POST['price'];

    // Ensure the uploads directory exists
    $uploads_dir = __DIR__ . "/uploads"; // Changed DIR to _DIR_
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    $file_path = $uploads_dir . "/" . basename($_FILES["file"]["name"]);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        $sql = "INSERT INTO notes (user_id, title, description, file_path, price) VALUES ('$user_id', '$title', '$description', '$file_path', '$price')";

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
    <title>Upload Note</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <div class="container">
            <h1><a href="index.php">HamroNotes</a></h1>
            <nav>
                <a href="index.php">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="upload.php">Upload Note</a>
                    <a href="notes.php">All Notes</a>
                    <a href="about.php">About Us</a>
                    <a href="logout.php">Logout</a>
                    <a href="profile.php" class="user-icon" title="Profile"><i class="fas fa-user"></i></a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="registration.php">Register</a>
                <?php endif; ?>
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
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
            </div>
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

    <script src="script.js"></script>
</body>
</html>