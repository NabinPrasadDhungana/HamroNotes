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
    $file_path = "uploads/" . basename($_FILES["file"]["name"]);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        $sql = "INSERT INTO notes (user_id, title, description, file_path, price) VALUES ('$user_id', '$title', '$description', '$file_path', '$price')";

        if ($conn->query($sql) === TRUE) {
            echo "Note uploaded successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Note</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Upload Note</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <br>
        <label for="file">File:</label>
        <input type="file" id="file" name="file" required>
        <br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
