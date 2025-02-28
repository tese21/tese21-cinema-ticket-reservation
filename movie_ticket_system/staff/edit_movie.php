<?php
// Include database connection
include '../config/db.php';

// Check if the movie ID is passed in the URL
if (isset($_GET['id'])) {
    $movieID = $_GET['id'];

    // Fetch the movie details from the database
    $sql = "SELECT * FROM movie WHERE MovieID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movieID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if movie is found
    if ($result->num_rows == 0) {
        echo "Movie not found.";
        exit;
    }

    $movie = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission for updating the movie
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_movie'])) {
    $movieID = $_POST['movieID'];
    $movieTitle = $_POST['movieTitle'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $cast = $_POST['cast'];
    $createdDate = $_POST['createdDate'];

    // Handle file upload (update image)
    $targetDir = "../uploads/";
    $movieImage = $movie['ProfileImage']; // Default to the existing image

    if (!empty($_FILES["ProfileImage"]["name"])) {
        $movieImage = basename($_FILES["ProfileImage"]["name"]);
        $targetFilePath = $targetDir . $movieImage;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validate file type
        if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            if (move_uploaded_file($_FILES["ProfileImage"]["tmp_name"], $targetFilePath)) {
                // Image successfully uploaded
            } else {
                echo "Failed to upload the image. Please check folder permissions.";
                exit;
            }
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }
    }

    // Update movie details in the database
    $sql = "UPDATE movie SET MovieTitle = ?, Genre = ?, Director = ?, Cast = ?, CreatedDate = ?, ProfileImage = ? WHERE MovieID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $movieTitle, $genre, $director, $cast, $createdDate, $movieImage, $movieID);

    if ($stmt->execute()) {
        echo "Movie updated successfully!";
        header("Location: manage_movie.php"); // Redirect to manage movies page after update
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Edit Movie</h1>
        <a href="../index.php">Back to Home</a> | <a href="manage_movie.php">Back to Manage Movies</a>
    </header>
    <main>
        <form method="POST" action="edit_movie.php?id=<?php echo $movie['MovieID']; ?>" enctype="multipart/form-data">
            <label for="movie_title">Movie Title:</label>
            <input type="text" id="movie_title" name="movieTitle" value="<?php echo htmlspecialchars($movie['MovieTitle']); ?>" required><br><br>

            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($movie['Genre']); ?>" required><br><br>

            <label for="director">Director:</label>
            <input type="text" id="director" name="director" value="<?php echo htmlspecialchars($movie['Director']); ?>" required><br><br>

            <label for="cast">Cast:</label>
            <input type="text" id="cast" name="cast" value="<?php echo htmlspecialchars($movie['Cast']); ?>" required><br><br>

            <label for="created_date">Created Date:</label>
            <input type="date" id="created_date" name="createdDate" value="<?php echo htmlspecialchars($movie['CreatedDate']); ?>" required><br><br>

            <label for="movie_image">Movie Image:</label>
            <input type="file" id="movie_image" name="ProfileImage" accept="image/*"><br><br>
            <img src="../uploads/<?php echo htmlspecialchars($movie['ProfileImage']); ?>" alt="Current Movie Image" style="width: 100px; height: 150px; object-fit: cover;"><br><br>

            <button type="submit" name="update_movie">Update Movie</button>
        </form>
    </main>
</body>
</html>
