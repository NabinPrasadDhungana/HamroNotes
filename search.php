<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';
// include 'config.php';

// Check if the search query is set
if (isset($_GET['query'])) {
    $searchQuery = trim($_GET['query']);
    $searchQuery = mysqli_real_escape_string($conn, $searchQuery); // Secure the query

    // Prepare the SQL statement to search notes by title or description
    $sql = "SELECT notes.id, notes.title, notes.description, notes.file_path, users.username
        FROM notes
        JOIN users ON notes.user_id = users.id
        WHERE notes.title LIKE '%$searchQuery%' 
           OR notes.description LIKE '%$searchQuery%' 
           OR users.username LIKE '%$searchQuery%'
        ORDER BY notes.created_at DESC";

    $result = $conn->query($sql);
} else {
    // If no query is provided, redirect to the notes page or show an error
    header("Location: notes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | HamroNotes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-...your-integrity-hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <div class="container">
            <div class="branding">
                <h1><a href="index.php">HamroNotes</a></h1>
            </div>
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

    <main class="container">
        <section id="search-results">
            <h2>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
            <div class="notes-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='note-card'>";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                        echo "<p class='user'>User: " . htmlspecialchars($row['username']) . "</p>";
                        echo "<a class='btn btn-primary' href='download.php?id=" . urlencode($row['id']) . "'>Download</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No notes found matching your search criteria.</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 HamroNotes. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>