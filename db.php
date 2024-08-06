<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "study_notes_clone";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
?>
