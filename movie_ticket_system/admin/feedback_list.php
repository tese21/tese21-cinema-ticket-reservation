<?php
session_start();
include('../config/db.php');

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
    exit();
}

// Pagination logic
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of records
$total_query = "SELECT COUNT(*) FROM feedback";
$total_result = mysqli_query($conn, $total_query);
$total_records = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_records / $limit);

// Fetch feedback from the database with pagination
$sql = "SELECT f.FeedbackID, f.MovieID, f.Rating, f.FeedbackDescription, f.FeedbackDate, f.UserID, m.MovieTitle, u.Fname, u.Lname 
        FROM feedback f 
        JOIN movie m ON f.MovieID = m.MovieID 
        JOIN user u ON f.UserID = u.UserID 
        LIMIT $start, $limit";
$query = mysqli_query($conn, $sql);

if ($query === false) {
    // If query fails, log the error
    die('Error executing query: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feedback List - Movie Ticket Reservation</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style.css.map">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/header.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Feedback List</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Feedback ID</th>
                                                <th>Movie Title</th>
                                            
                                                <th>Rating</th>
                                                <th>Feedback Description</th>
                                                <th>Feedback Date</th>
                                                <th>User Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlentities($row['FeedbackID']) . "</td>";
                                                echo "<td>" . htmlentities($row['MovieTitle']) . "</td>";
                                        
                                                echo "<td>" . htmlentities($row['Rating']) . "</td>";
                                                echo "<td>" . htmlentities($row['FeedbackDescription']) . "</td>";
                                                echo "<td>" . htmlentities($row['FeedbackDate']) . "</td>";
                                                echo "<td>" . htmlentities($row['Fname'] . ' ' . $row['Lname']) . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination controls -->
                                <div class="flex justify-center mt-4">
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                        <a href="?page=<?php echo max(1, $page - 1); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span>Previous</span>
                                        </a>
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $i == $page ? 'text-yellow-500' : 'text-gray-500'; ?> hover:bg-gray-50">
                                                <?php echo $i; ?>
                                            </a>
                                        <?php endfor; ?>
                                        <a href="?page=<?php echo min($total_pages, $page + 1); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span>Next</span>
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
</div>
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="vendors/chart.js/Chart.min.js"></script>
<script src="vendors/moment/moment.min.js"></script>
<script src="vendors/daterangepicker/daterangepicker.js"></script>
<script src="vendors/chartist/chartist.min.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/misc.js"></script>
<script src="js/dashboard.js"></script>
</body>
</html>