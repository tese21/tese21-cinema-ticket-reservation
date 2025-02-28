<?php
// Include database connection
include 'config/db.php';

// Fetch at least 6 movies to display movie titles and images
$sql = "SELECT MovieTitle, ProfileImage FROM movie LIMIT 6"; // Limit to 6 movies
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Loop through the result and output images
    while ($movie = $result->fetch_assoc()) {
        echo '<a href="booking.php?movie=' . urlencode($movie['MovieTitle']) . '" class="movie-link">';
        echo '<img src="uploads/' . htmlspecialchars($movie['ProfileImage']) . '" alt="' . htmlspecialchars($movie['MovieTitle']) . '">';
        echo '</a>';
    }
} else {
    echo '<p>No movies available.</p>';
}

// Close the database connection
$conn->close();
?>
