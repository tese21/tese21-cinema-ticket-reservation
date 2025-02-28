<?php
session_start();
include('../config/db.php');

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['UserID']) || $_SESSION['role'] != 'Staff') {
    header('location:../login.php');
    exit();
}

$searchResults = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['searchTerm'] ?? '';

    // Search movies
    $sqlMovies = "SELECT * FROM movie WHERE MovieTitle LIKE ?";
    $stmtMovies = $conn->prepare($sqlMovies);
    $searchTermLike = '%' . $searchTerm . '%';
    $stmtMovies->bind_param("s", $searchTermLike);
    $stmtMovies->execute();
    $resultMovies = $stmtMovies->get_result();
    $movies = $resultMovies->fetch_all(MYSQLI_ASSOC);

    // Search movie schedules
    $sqlSchedules = "SELECT ms.*, m.MovieTitle FROM movie_schedule ms JOIN movie m ON ms.MovieID = m.MovieID WHERE m.MovieTitle LIKE ?";
    $stmtSchedules = $conn->prepare($sqlSchedules);
    $stmtSchedules->bind_param("s", $searchTermLike);
    $stmtSchedules->execute();
    $resultSchedules = $stmtSchedules->get_result();
    $schedules = $resultSchedules->fetch_all(MYSQLI_ASSOC);

    // Search tickets
    $sqlTickets = "SELECT t.*, u.Fname, u.Lname, ms.MovieID, m.MovieTitle FROM ticket t JOIN user u ON t.UserID = u.UserID JOIN movie_schedule ms ON t.ScheduleID = ms.ScheduleID JOIN movie m ON ms.MovieID = m.MovieID WHERE m.MovieTitle LIKE ? OR u.Fname LIKE ? OR u.Lname LIKE ?";
    $stmtTickets = $conn->prepare($sqlTickets);
    $stmtTickets->bind_param("sss", $searchTermLike, $searchTermLike, $searchTermLike);
    $stmtTickets->execute();
    $resultTickets = $stmtTickets->get_result();
    $tickets = $resultTickets->fetch_all(MYSQLI_ASSOC);

    // Search customers
    $sqlCustomers = "SELECT * FROM user WHERE (Fname LIKE ? OR Lname LIKE ?) AND Role = 'Customer'";
    $stmtCustomers = $conn->prepare($sqlCustomers);
    $stmtCustomers->bind_param("ss", $searchTermLike, $searchTermLike);
    $stmtCustomers->execute();
    $resultCustomers = $stmtCustomers->get_result();
    $customers = $resultCustomers->fetch_all(MYSQLI_ASSOC);

    $searchResults = [
        'movies' => $movies,
        'schedules' => $schedules,
        'tickets' => $tickets,
        'customers' => $customers
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - Movie Ticket Reservation</title>
    <link rel="stylesheet" href="../admin/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../admin/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../admin/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../admin/vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../admin/vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="../admin/css/styles.css">
    <link rel="stylesheet" href="../admin/css/style.css.map">
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
                                <h4 class="card-title">Search</h4>
                                <form method="POST" action="search.php">
                                    <div class="form-group">
                                        <input type="text" name="searchTerm" class="form-control" placeholder="Search for movies, schedules, tickets, customers..." required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                                <?php if (!empty($searchResults)): ?>
                                    <div class="mt-4">
                                        <h5>Search Results</h5>
                                        <?php if (!empty($searchResults['movies'])): ?>
                                            <h6>Movies</h6>
                                            <ul>
                                                <?php foreach ($searchResults['movies'] as $movie): ?>
                                                    <li><?php echo htmlspecialchars($movie['MovieTitle']); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <?php if (!empty($searchResults['schedules'])): ?>
                                            <h6>Movie Schedules</h6>
                                            <ul>
                                                <?php foreach ($searchResults['schedules'] as $schedule): ?>
                                                    <li><?php echo htmlspecialchars($schedule['MovieTitle']) . ' - ' . htmlspecialchars($schedule['StartTime']); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <?php if (!empty($searchResults['tickets'])): ?>
                                            <h6>Tickets</h6>
                                            <ul>
                                                <?php foreach ($searchResults['tickets'] as $ticket): ?>
                                                    <li><?php echo 'Movie: ' . htmlspecialchars($ticket['MovieTitle']) . ' - Customer: ' . htmlspecialchars($ticket['Fname']) . ' ' . htmlspecialchars($ticket['Lname']) . ' - Issued Date: ' . htmlspecialchars($ticket['IssuedDate']); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <?php if (!empty($searchResults['customers'])): ?>
                                            <h6>Customers</h6>
                                            <ul>
                                                <?php foreach ($searchResults['customers'] as $customer): ?>
                                                    <li><?php echo htmlspecialchars($customer['Fname']) . ' ' . htmlspecialchars($customer['Lname']); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
</div>
<script src="../admin/vendors/js/vendor.bundle.base.js"></script>
<script src="../admin/vendors/chart.js/Chart.min.js"></script>
<script src="../admin/vendors/moment/moment.min.js"></script>
<script src="../admin/vendors/daterangepicker/daterangepicker.js"></script>
<script src="../admin/vendors/chartist/chartist.min.js"></script>
<script src="../admin/js/off-canvas.js"></script>
<script src="../admin/js/misc.js"></script>
<script src="../admin/js/dashboard.js"></script>
</body>
</html>