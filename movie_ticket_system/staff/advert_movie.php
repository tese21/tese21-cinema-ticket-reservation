<?php
// Include database connection
include '../config/db.php';

// Handle advertisement logic (if any, e.g., set as featured)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['advert_movie'])) {
    $movie_id = $_POST['movie_id'];
    $advertisement_status = 1;  // Flag as advertised

    $sql = "UPDATE movies SET AdvertisementStatus = '$advertisement_status' WHERE MovieID = '$movie_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Movie advertised successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all movies for selection
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advertise Movie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Advertise Movie</h1>
        <a href="../index.php">Back to Home</a>
    </header>
    <main>
        <form method="POST" action="advert_movie.php">
            <label for="movie_id">Select Movie to Advertise:</label>
            <select name="movie_id" id="movie_id" required>
                <?php while ($movie = $result->fetch_assoc()): ?>
                    <option value="<?php echo $movie['MovieID']; ?>"><?php echo $movie['MovieTitle']; ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <button type="submit" name="advert_movie">Advertise Movie</button>
        </form>
    </main>
</body>
</html>
