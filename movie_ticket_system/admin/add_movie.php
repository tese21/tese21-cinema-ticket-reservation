<?php
// Include database connection
include '../config/db.php';
$successMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_movie'])) {
    $movieTitle = $_POST['movie_title'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $cast = $_POST['cast'];
    $createdDate = $_POST['created_date'];
    $movieDescription = $_POST['movie_description'];

    // Handle file upload
    $targetDir = "../uploads/";
    $movieImage = basename($_FILES["ProfileImage"]["name"]);
    $targetFilePath = $targetDir . $movieImage;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $maxFileSize = 2 * 1024 * 1024; // 2MB limit

    // Ensure the uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Validate file size
    if ($_FILES["ProfileImage"]["size"] > $maxFileSize) {
        $errorMessage = "File size should not exceed 2MB.";
    } else {
        if (move_uploaded_file($_FILES["ProfileImage"]["tmp_name"], $targetFilePath)) {
            // Check if movie already exists
            $stmt = $conn->prepare("SELECT * FROM movie WHERE MovieTitle = ?");
            $stmt->bind_param("s", $movieTitle);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $errorMessage = "Movie with this title already exists.";
            } else {
                // Insert movie data into database
                $stmt = $conn->prepare("INSERT INTO movie (MovieTitle, Genre, Director, Cast, CreatedDate, ProfileImage, movie_description) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $movieTitle, $genre, $director, $cast, $createdDate, $movieImage, $movieDescription);

                if ($stmt->execute()) {
                    $successMessage = "New movie added successfully!";
                } else {
                    $errorMessage = "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            $errorMessage = "Failed to upload the image. Please check folder permissions.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-4">Add New Movie</h1>
        <form method="POST" action="add_movie.php" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="movie_title" class="block font-semibold">Movie Title:</label>
                <input type="text" id="movie_title" name="movie_title" class="w-full p-2 border rounded-md" required>
            </div>
            <div>
                <label for="genre" class="block font-semibold">Genre:</label>
                <input type="text" id="genre" name="genre" class="w-full p-2 border rounded-md" required>
            </div>
            <div>
                <label for="director" class="block font-semibold">Director:</label>
                <input type="text" id="director" name="director" class="w-full p-2 border rounded-md" required>
            </div>
            <div>
                <label for="cast" class="block font-semibold">Cast:</label>
                <input type="text" id="cast" name="cast" class="w-full p-2 border rounded-md" required>
            </div>
            <div>
                <label for="created_date" class="block font-semibold">Created Date:</label>
                <input type="date" id="created_date" name="created_date" class="w-full p-2 border rounded-md" required>
            </div>
            <div>
                <label for="movie_description" class="block font-semibold">Movie Description:</label>
                <textarea id="movie_description" name="movie_description" class="w-full p-2 border rounded-md" required></textarea>
            </div>
            <div>
                <label for="movie_image" class="block font-semibold">Movie Image:</label>
                <input type="file" id="movie_image" name="ProfileImage" class="w-full p-2 border rounded-md" accept="image/*" required>
            </div>
            <button type="submit" name="add_movie" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Add Movie</button>
        </form>
        <button onclick="window.location.href='admin_dashboard.php'" class="w-full bg-gray-500 text-white py-2 rounded-md hover:bg-gray-600 mt-3">Back</button>
    </div>

    <?php if (!empty($successMessage)): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= $successMessage ?>'
            });
        </script>
    <?php elseif (!empty($errorMessage)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= $errorMessage ?>'
            });
        </script>
    <?php endif; ?>
</body>
</html>
