<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$sql = "SELECT username, email FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Fetch user uploaded notes
$sql_notes = "SELECT title, description, file_path, price FROM notes WHERE user_id = '$user_id'";
$notes_result = $conn->query($sql_notes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">HamroNotes</a></h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="upload.php">Upload Note</a>
                <a href="about.php">About Us</a>
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <main class="profile-container">
        <h2>User Profile</h2>
        <div class="profile-info">
            <h3>Personal Information</h3>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <div class="profile-notes">
            <h3>Your Uploaded Notes</h3>
            <?php if ($notes_result->num_rows > 0): ?>
                <ul class="notes-list">
                    <?php while ($note = $notes_result->fetch_assoc()): ?>
                        <li>
                            <h4><?php echo htmlspecialchars($note['title']); ?></h4>
                            <p><?php echo htmlspecialchars($note['description']); ?></p>
                            <p><strong>Price:</strong> $<?php echo htmlspecialchars($note['price']); ?></p>
                            <a href="<?php echo htmlspecialchars($note['file_path']); ?>" download>Download</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No notes uploaded yet.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 HamroNotes</p>
    </footer>
</body>
</html>
