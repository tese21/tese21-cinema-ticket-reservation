<?php
// Include database connection
include '../config/db.php';

// Check if the movie ID is provided
if (isset($_GET['MovieID'])) {
    $movieID = intval($_GET['MovieID']); // Ensure it's an integer

    // Query to fetch the current movie details
    $sql = "SELECT * FROM movie WHERE MovieID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $movieID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "<script>alert('Movie not found!'); window.location.href='movie_list.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='movie_list.php';</script>";
    exit;
}

// Handle form submission for updating movie
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated values from the form (sanitization added)
    $movieTitle = htmlspecialchars(trim($_POST['movie_title']));
    $genre = htmlspecialchars(trim($_POST['genre']));
    $director = htmlspecialchars(trim($_POST['director']));
    $cast = htmlspecialchars(trim($_POST['cast']));
    $createdDate = $_POST['created_date'];
    $movieDescription = htmlspecialchars(trim($_POST['movie_description']));

    // Handle profile photo upload
    $profileImage = $movie['ProfileImage']; // Default to current profile image
    if (isset($_FILES['ProfileImage']) && $_FILES['ProfileImage']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES['ProfileImage']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['ProfileImage']['tmp_name']);
        if ($check !== false) {
            // Check file size (limit to 5MB)
            if ($_FILES['ProfileImage']['size'] <= 5000000) {
                // Allow certain file formats
                if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES['ProfileImage']['tmp_name'], $targetFile)) {
                        $profileImage = basename($_FILES['ProfileImage']['name']);
                    } else {
                        echo "<script>alert('Error uploading profile image.');</script>";
                    }
                } else {
                    echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
                }
            } else {
                echo "<script>alert('File size exceeds the limit of 5MB.');</script>";
            }
        } else {
            echo "<script>alert('File is not an image.');</script>";
        }
    }

    // Update the movie details in the database
    $sql = "UPDATE movie 
            SET MovieTitle = ?, Genre = ?, Director = ?, Cast = ?, CreatedDate = ?, ProfileImage = ?, movie_description = ? 
            WHERE MovieID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssi', $movieTitle, $genre, $director, $cast, $createdDate, $profileImage, $movieDescription, $movieID);

    if ($stmt->execute()) {
        echo "<script>alert('Movie details updated successfully!'); window.location.href='movie_list.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating movie details.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Movie</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container my-4">
        <h1 class="text-center mb-4">Update Movie</h1>
        
        <div class="card p-4 shadow-lg">
            <form action="update_movie.php?MovieID=<?php echo $movieID; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="movie_title">Movie Title</label>
                    <input type="text" id="movie_title" name="movie_title" class="form-control" value="<?php echo htmlspecialchars($movie['MovieTitle']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" class="form-control" value="<?php echo htmlspecialchars($movie['Genre']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="director">Director</label>
                    <input type="text" id="director" name="director" class="form-control" value="<?php echo htmlspecialchars($movie['Director']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="cast">Cast</label>
                    <input type="text" id="cast" name="cast" class="form-control" value="<?php echo htmlspecialchars($movie['Cast']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="created_date">Created Date</label>
                    <input type="date" id="created_date" name="created_date" class="form-control" value="<?php echo $movie['CreatedDate']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="movie_description">Movie Description</label>
                    <textarea id="movie_description" name="movie_description" class="form-control" required><?php echo htmlspecialchars($movie['movie_description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="ProfileImage">Profile Image</label>
                    <input type="file" id="ProfileImage" name="ProfileImage" class="form-control" accept="image/*">
                    <img src="../uploads/<?php echo htmlspecialchars($movie['ProfileImage']); ?>" alt="Movie Poster" class="img-thumbnail mt-2" width="100">
                </div>

                <button type="submit" class="btn btn-primary">Update Movie</button>
                <a href="movie_list.php" class="btn btn-secondary ml-2">Cancel</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>