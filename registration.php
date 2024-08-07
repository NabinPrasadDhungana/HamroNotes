<?php
session_start();
include 'db.php';

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $username = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = [];

    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        $errors[] = "All fields are required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    if ($password !== $passwordRepeat) {
        $errors[] = "Passwords do not match";
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Debugging: Check SQL query
        $email = mysqli_real_escape_string($conn, $email);
        $username = mysqli_real_escape_string($conn, $username);

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "<div class='alert alert-danger'>Query failed: " . mysqli_error($conn) . "</div>";
        } elseif (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger'>Email already exists!</div>";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION["user_id"] = mysqli_insert_id($conn); // Set session on successful registration
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Registration failed: " . mysqli_error($conn) . "</div>";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
            }
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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
        <div class="menu-toggle"><i class="fas fa-bars"></i></div>
        <nav class="nav-menu">
            <a href="index.php">Home</a>
            <a href="notes.php">All Notes</a>
            <a href="about.php">About Us</a>
            <a href="index.php#contact">Contact</a>
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
    <div class="form-container">
        <h2>Register</h2>
        <form action="registration.php" method="POST">
    <div class="form-group">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter your full name" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
    </div>
    <div class="form-group">
        <label for="repeat_password">Repeat Password:</label>
        <input type="password" id="repeat_password" name="repeat_password" class="form-control" placeholder="Repeat your password" required>
    </div>
    <div class="form-btn">
        <button type="submit" name="submit" class="btn btn-primary">Register</button>
    </div>
</form>

        <div class="registration-link">
            <p>Already registered? <a href="login.php">Login here</a></p>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 HamroNotes</p>
</footer>

<script src="script.js"></script>
</body>
</html>
