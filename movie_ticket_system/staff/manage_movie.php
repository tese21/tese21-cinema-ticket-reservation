<?php
// Include database connection
include '../config/db.php';

// Handle form submission for adding a movie

// Fetch all movies for display
$sql = "SELECT * FROM movie";
$result = $conn->query($sql);
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
    <header>
        <h1>Manage Movies</h1>
       <?php include '../customer/search_movie.php';?>
        <a href="../index.php">Back to Home</a>
    </header>
    <main>
    

        <h2>Movie List</h2>
        <table>
            <thead>
                <tr>
                    <th>ProfileImage</th>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Director</th>
                    <th>Cast</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($movie = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="../uploads/<?php echo htmlspecialchars($movie['ProfileImage']); ?>" alt="Movie Image" class="movie-image">
                    </td>
                    <td><?php echo htmlspecialchars($movie['MovieTitle']); ?></td>
                    <td><?php echo htmlspecialchars($movie['Genre']); ?></td>
                    <td><?php echo htmlspecialchars($movie['Director']); ?></td>
                    <td><?php echo htmlspecialchars($movie['Cast']); ?></td>
                    <td><?php echo htmlspecialchars($movie['CreatedDate']); ?></td>
                    <td>
                        <a href="edit_movie.php?id=<?php echo $movie['MovieID']; ?>">Edit</a> | 
                        <a href="delete_movie.php?id=<?php echo $movie['MovieID']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
