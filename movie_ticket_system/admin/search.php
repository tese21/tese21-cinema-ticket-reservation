<?php
include('../config/db.php');

// Handle movie deletion
if (isset($_GET['delid'])) {
  $movie_id = intval($_GET['delid']);
  $sql = "DELETE FROM movies WHERE MovieID=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $movie_id);
  $stmt->execute();
  $stmt->close();

  echo "<script>alert('Movie deleted');</script>";
  echo "<script>window.location.href = 'movies-dashboard.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Movie Ticket System | Search Movies</title>
    <!-- Add your stylesheets and plugins here -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/styles.css">
    
     
       
        <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/style.css.map">
</head>
<body>
    <div class="container-scroller">
        <!-- Include the navbar -->
        <?php include_once('includes/header.php');?>

        <div class="container-fluid page-body-wrapper">
            <!-- Include the sidebar -->
            <?php include_once('includes/sidebar.php');?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Search Movie </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Search Movie</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <strong>Search Movie:</strong>
                                            <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Search by Movie ID or Movie Name">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="search" id="submit">Search</button>
                                    </form>
                                    
                                    <div class="d-sm-flex align-items-center mb-4">
                                    <?php
                                    if (isset($_POST['search'])) {
                                        $sdata = $_POST['searchdata'];
                                    ?>
                                    <hr />
                                    <h4 align="center">Result against "<?php echo $sdata;?>" keyword</h4>
                                    </div>

                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">S.No</th>
                                                    <th class="font-weight-bold">Movie ID</th>
                                                    <th class="font-weight-bold">Movie Name</th>
                                                    <th class="font-weight-bold">Genre</th>
                                                    <th class="font-weight-bold">Release Date</th>
                                                    <th class="font-weight-bold">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['pageno'])) {
                                                    $pageno = $_GET['pageno'];
                                                } else {
                                                    $pageno = 1;
                                                }

                                                // Pagination logic
                                                $no_of_records_per_page = 5;
                                                $offset = ($pageno - 1) * $no_of_records_per_page;

                                                $sql = "SELECT COUNT(MovieID) FROM movies WHERE MovieID LIKE '%$sdata%' OR MovieName LIKE '%$sdata%'";
                                                $result = $conn->query($sql);
                                                $row = $result->fetch_row();
                                                $total_rows = $row[0];
                                                $total_pages = ceil($total_rows / $no_of_records_per_page);

                                                $sql = "SELECT MovieID, MovieName, Genre, ReleaseDate FROM movies WHERE MovieID LIKE '%$sdata%' OR MovieName LIKE '%$sdata%' LIMIT $offset, $no_of_records_per_page";
                                                $query = $conn->query($sql);

                                                $cnt = 1;
                                                if ($query->num_rows > 0) {
                                                    while ($row = $query->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row['MovieID']); ?></td>
                                                            <td><?php echo htmlentities($row['MovieName']); ?></td>
                                                            <td><?php echo htmlentities($row['Genre']); ?></td>
                                                            <td><?php echo htmlentities($row['ReleaseDate']); ?></td>
                                                            <td>
                                                                <div>
                                                                    <a href="edit-movie-detail.php?editid=<?php echo htmlentities($row['MovieID']); ?>" class="btn btn-info btn-xs" target="blank">Edit</a>
                                                                    <a href="search.php?delid=<?php echo $row['MovieID']; ?>" onclick="return confirm('Do you really want to delete?');" class="btn btn-danger btn-xs">Delete</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $cnt++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6">No record found against this search</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div align="left" class="mt-4">
                                        <ul class="pagination">
                                            <li><a href="?pageno=1"><strong>First</strong></a></li>
                                            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=" . ($pageno - 1); } ?>"><strong>Prev</strong></a>
                                            </li>
                                            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=" . ($pageno + 1); } ?>"><strong>Next</strong></a>
                                            </li>
                                            <li><a href="?pageno=<?php echo $total_pages; ?>"><strong>Last</strong></a></li>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- Include the footer -->
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- End inject -->
</body>
</html>
