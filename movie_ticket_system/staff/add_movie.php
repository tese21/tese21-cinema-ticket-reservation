
<?php
// Include database connection
include '../config/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_movie'])) {
    $movieTitle = $_POST['movie_title'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $cast = $_POST['cast'];
    $createdDate = $_POST['created_date'];

    // Handle file upload
    $targetDir = "../uploads/";
    $movieImage = basename($_FILES["ProfileImage"]["name"]);
    $targetFilePath = $targetDir . $movieImage;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Ensure the uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory if it doesn't exist
    }

    // Validate file type
    if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        if (move_uploaded_file($_FILES["ProfileImage"]["tmp_name"], $targetFilePath)) {
            // Use prepared statements to insert movie details into the database
            $stmt = $conn->prepare("INSERT INTO movie (MovieTitle, Genre, Director, Cast, CreatedDate, ProfileImage) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $movieTitle, $genre, $director, $cast, $createdDate, $movieImage);

            if ($stmt->execute()) {
                echo "New movie added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Failed to upload the image. Please check folder permissions.";
        }
    } else {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .movie-image {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<form method="POST" action="manage_movie.php" enctype="multipart/form-data">
            <label for="movie_title">Movie Title:</label>
            <input type="text" id="movie_title" name="movie_title" required><br><br>

            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required><br><br>

            <label for="director">Director:</label>
            <input type="text" id="director" name="director" required><br><br>

            <label for="cast">Cast:</label>
            <input type="text" id="cast" name="cast" required><br><br>

            <label for="created_date">Created Date:</label>
            <input type="date" id="created_date" name="created_date" required><br><br>

            <label for="movie_image">Movie Image:</label>
            <input type="file" id="movie_image" name="ProfileImage" accept="image/*" required><br><br>

            <button type="submit" name="add_movie">Add Movie</button>
        </form>
</body>