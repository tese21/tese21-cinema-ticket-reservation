<?php
// Include database connection
include '../config/db.php';

// Check if MovieID is set in the URL
if (isset($_GET['MovieID'])) {
    $movie_id = $_GET['MovieID'];

    // Prepare delete statement
    $sql = "DELETE FROM movie WHERE MovieID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $movie_id);

    if ($stmt->execute()) {
        echo "<script>alert('Movie deleted successfully!'); window.location.href='movie_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting movie!'); window.location.href='movie_list.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='movie_list.php';</script>";
}

$conn->close();
?>