<?php
// Include the database connection
include '../config/db.php'; // Adjust the filename if necessary

// Handle search input
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Query to select all rows from the movie table
$sql = "SELECT * FROM movie";
if ($search != '') {
    $sql .= " WHERE MovieID LIKE '%$search%' OR MovieTitle LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container my-4">
        <h1 class="text-center mb-4">Movie List</h1>
        
        <form method="post" action="">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Movie ID or Title" value="<?php echo htmlentities($search); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Movie ID</th>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Director</th>
                        <th>Cast</th>
                        <th>Created Date</th>
                        <th>Poster</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Construct the image path (assuming the images are stored in 'uploads/')
                            $imagePath = '../uploads/' . $row['ProfileImage'];
                            // Truncate the description to 100 characters
                            $description = strlen($row['movie_description']) > 100 ? substr($row['movie_description'], 0, 100) . '...' : $row['movie_description'];
                            echo "<tr>
                                <td>{$row['MovieID']}</td>
                                <td>{$row['MovieTitle']}</td>
                                <td>{$row['Genre']}</td>
                                <td>{$row['Director']}</td>
                                <td>{$row['Cast']}</td>
                                <td>{$row['CreatedDate']}</td>
                                <td><img src='{$imagePath}' alt='Movie Poster' class='img-thumbnail' width='80'></td>
                                <td>{$description} <a href='#' data-toggle='modal' data-target='#descriptionModal{$row['MovieID']}'>Read More</a></td>
                                <td>
                                    <a href='update_movie.php?MovieID={$row['MovieID']}' class='btn btn-info btn-sm'>
                                        <i class='fas fa-edit'></i> Update
                                    </a>
                                    <a href='delete_movie.php?MovieID={$row['MovieID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this movie?\")'>
                                        <i class='fas fa-trash'></i> Delete
                                    </a>
                                </td>
                            </tr>";
                            // Modal for full description
                            echo "<div class='modal fade' id='descriptionModal{$row['MovieID']}' tabindex='-1' role='dialog' aria-labelledby='descriptionModalLabel{$row['MovieID']}' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='descriptionModalLabel{$row['MovieID']}'>Movie Description</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            {$row['movie_description']}
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No movies found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <a href="admin_dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>