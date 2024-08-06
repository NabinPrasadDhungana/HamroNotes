<?php
session_start();
require_once "db.php";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

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
            echo "<div class='alert alert-danger'>Invalid email or password</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Database error. Please try again later.</div>";
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
    <title>Login Form</title>
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

    <main class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" placeholder="Enter your email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" placeholder="Enter your password" name="password" class="form-control" required>
                </div>
                <div class="form-btn">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
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
</body>
</html>
