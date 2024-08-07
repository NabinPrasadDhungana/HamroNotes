<?php
session_start();
require_once "db.php";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        echo "<div class='alert alert-danger'>Please fill in all fields.</div>";
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                header("Location: index.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Invalid email or password.</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Database error. Please try again later.</div>";
        }

        mysqli_close($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
    <div class="form-container">
        <h2>Login</h2>
        <?php if (!empty($error_message)): ?>
            <div class='alert alert-danger'><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" placeholder="Enter your email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" placeholder="Enter your password" name="password" class="form-control" required>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" type="submit" name="login" class="btn btn-primary">
            </div>
        </form>
        <div class="registration-link">
            <p>Not registered yet? <a href="registration.php">Register Here</a></p>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 HamroNotes</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const hamburgerToggle = document.querySelector('.hamburger-toggle');
    const navLinks = document.getElementById('nav-links');

    if (hamburgerToggle) {
        hamburgerToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
});

</script>

<script src="script.js"></script>
</body>
</html>
