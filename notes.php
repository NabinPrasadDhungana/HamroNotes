<?php
include 'db.php';

$sql = "SELECT * FROM notes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notes Listing</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Available Notes</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h2>" . $row['title'] . "</h2>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "<a href='download.php?id=" . $row['id'] . "'>Download</a>";
            echo "</div>";
        }
    } else {
        echo "No notes available";
    }
    ?>
</body>
</html>
