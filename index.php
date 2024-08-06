<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<?php
include 'db.php';
session_start();

// Fetch featured notes (limit to the latest 5 notes as an example)
$sql = "SELECT * FROM notes ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | HamroNotes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-...your-integrity-hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <section id="search">
            <h2>Find Your Notes</h2>
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search for notes..." required>
                <button type="submit">Search</button>
            </form>
        </section>

        <section id="featured-notes">
            <h2>Featured Notes</h2>
            <div class="notes-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='note-card'>";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                        echo "<p class='price'>Price: $" . htmlspecialchars($row['price']) . "</p>";
                        echo "<a class='btn btn-primary' href='download.php?id=" . htmlspecialchars($row['id']) . "'>Download</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No featured notes available</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 HamroNotes</p>
    </footer>
</body>
</html>
