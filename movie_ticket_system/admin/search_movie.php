<?php
// Include database connection
include '../config/db.php';

// Handle form submission for searching movies
$movies = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_movie'])) {
    $title = $_POST['title'];

    // Use a prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM movie WHERE MovieTitle LIKE ? OR Director LIKE ?");
    $searchTerm = '%' . $title . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm); // "ss" indicates two strings

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $movies = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Movie</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Search for Movies</h1>
        <form method="POST" action="search_movie.php" class="form-inline justify-content-center mb-4">
            <div class="form-group mx-sm-3 mb-2">
                <label for="title" class="sr-only">Movie Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Movie Title" required>
            </div>
            <button type="submit" name="search_movie" class="btn btn-primary mb-2">Search</button>
        </form>

        <?php if (count($movies) > 0): ?>
            <h2 class="text-center">Results:</h2>
            <div class="row">
                <?php foreach ($movies as $movie): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../uploads/<?php echo htmlspecialchars($movie['ProfileImage']); ?>" alt="Movie Image" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($movie['MovieTitle']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($movie['Genre']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($movie['Director']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($movie['Cast']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($movie['movie_description']); ?></p>
                                <a href="edit_movie.php?id=<?php echo $movie['MovieID']; ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_movie.php?id=<?php echo $movie['MovieID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this movie?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (isset($_POST['search_movie'])): ?>
            <p class="text-center">No movies found with that title.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
