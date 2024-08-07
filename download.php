<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch file information from the database
    $sql = "SELECT file_path, title FROM notes WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];
        $file_name = basename($file_path);
        $file_title = $row['title'];
        
        // Debugging: Print the file path
        echo "Resolved File Path: " . realpath($file_path) . "<br>";
        if (file_exists($file_path)) {
            echo "File exists.";
        } else {
            echo "File does not exist.";
        }

        // Correct path to the file
        $file_path = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $file_name;

        // Debugging: Verify if the file exists
        if (file_exists($file_path)) {
            // Set headers to initiate download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            echo "File does not exist at path: " . $file_path;
        }
    } else {
        echo "No file found for the provided ID.";
    }
} else {
    echo "No ID provided.";
}
?>