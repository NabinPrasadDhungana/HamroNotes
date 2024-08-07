<?php
$servername = "localhost"; // Adjust as necessary
$username = "root"; // Adjust as necessary
$password = ""; // Adjust as necessary
$database = "study_notes_clone"; // Adjust as necessary

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
