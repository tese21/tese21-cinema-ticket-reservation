<?php
session_start();
include('../config/db.php');

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Movie Ticket Reservation</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style.css.map">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-sm-flex align-items-baseline report-summary-header">
                                            <h5 class="font-weight-semibold">Report Summary</h5>
                                            <span class="ml-auto">Updated Report</span>
                                            <a href="admin_update_report.php" class="btn btn-icons border-0 p-2">
                                                <i class="icon-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row report-inner-cards-wrapper">
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Total Movies
                                                $sql1 = "SELECT * FROM movie";
                                                $query1 = mysqli_query($conn, $sql1);
                                                
                                                if ($query1 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                            
                                                $totclass = mysqli_num_rows($query1);
                                            ?>
                                            <span class="report-title">Movie</span>
                                            <h4><?php echo htmlentities($totclass); ?></h4>
                                            <a href="movie_list.php"><span class="report-count"> View movie</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-success">
                                            <i class="icon-book-open"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Total Customers
                                                $sql2 = "SELECT * FROM user WHERE Role = 'Customer'";
                                                $query2 = mysqli_query($conn, $sql2);
                                                
                                                if ($query2 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totstu = mysqli_num_rows($query2);
                                            ?>
                                            <span class="report-title">Customer</span>
                                            <h4><?php echo htmlentities($totstu); ?></h4>
                                            <a href="customer_list.php"><span class="report-count"> customer list</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-danger">
                                            <i class="icon-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Total Staff
                                                $sql3 = "SELECT * FROM user WHERE Role = 'Staff'";
                                                $query3 = mysqli_query($conn, $sql3);
                                                
                                                if ($query3 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totnotice = mysqli_num_rows($query3);
                                            ?>
                                            <span class="report-title">Staff</span>
                                            <h4><?php echo htmlentities($totnotice); ?></h4>
                                            <a href="staff_list.php"><span class="report-count"> staff list</span></a>
                                        </div>
                                      
                                    </div>
                                </div>
                            
                                <div class="row report-inner-cards-wrapper">
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Total Tickets
                                                $sql4 = "SELECT * FROM transactions";
                                                $query4 = mysqli_query($conn, $sql4);
                                                
                                                if ($query4 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totticket = mysqli_num_rows($query4);
                                            ?>
                                            <span class="report-title">Ticket</span>
                                            <h4><?php echo htmlentities($totticket); ?></h4>
                                            <a href="ticket_list.php"><span class="report-count"> View tickets</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-info">
                                            <i class="icon-doc"></i>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Total Schedules
                                                $sql5 = "SELECT * FROM movie_schedule";
                                                $query5 = mysqli_query($conn, $sql5);
                                                
                                                if ($query5 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totschedule = mysqli_num_rows($query5);
                                            ?>
                                            <span class="report-title">Schedule</span>
                                            <h4><?php echo htmlentities($totschedule); ?></h4>
                                            <a href="add_schedule.php"><span class="report-count"> Add schedules</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-primary">
                                            <i class="icon-calendar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Total Movie Schedules
                                                $sql6 = "SELECT * FROM movie_schedule";
                                                $query6 = mysqli_query($conn, $sql6);
                                                
                                                if ($query6 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totmovieschedule = mysqli_num_rows($query6);
                                            ?>
                                            <span class="report-title">Movie Schedule</span>
                                            <h4><?php echo htmlentities($totmovieschedule); ?></h4>
                                            <a href="manage_schedule.php"><span class="report-count"> View movie schedules</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-secondary">
                                            <i class="icon-film"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Total Feedbacks
                                                $sql7 = "SELECT * FROM feedback";
                                                $query7 = mysqli_query($conn, $sql7);
                                                
                                                if ($query7 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totfeedback = mysqli_num_rows($query7);
                                            ?>
                                            <span class="report-title">Feedback</span>
                                            <h4><?php echo htmlentities($totfeedback); ?></h4>
                                            <a href="feedback_list.php"><span class="report-count"> View feedback</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-purple">
                                            <i class="icon-speech"></i>
                                        </div>
                                    </div>
                                  
                                    
                                <div class="row report-inner-cards-wrapper">
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Add Movie
                                                $sql10 = "SELECT * FROM movie";
                                                $query10 = mysqli_query($conn, $sql10);
                                                
                                                if ($query10 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totaddmovie = mysqli_num_rows($query10);
                                            ?>
                                            <span class="report-title">Add Movie</span>
                                            <h4><?php echo htmlentities($totaddmovie); ?></h4>
                                            <a href="add_movie.php"><span class="report-count"> Add movie</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-teal">
                                            <i class="icon-film"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl report-inner-card">
                                        <div class="inner-card-text">
                                            <?php 
                                                // Database query for Add Staff
                                                $sql11 = "SELECT * FROM user WHERE Role = 'Staff'";
                                                $query11 = mysqli_query($conn, $sql11);
                                                
                                                if ($query11 === false) {
                                                    // If query fails, log the error
                                                    die('Error executing query: ' . mysqli_error($conn));
                                                }
                                                
                                                $totaddstaff = mysqli_num_rows($query11);
                                            ?>
                                            <span class="report-title">Add Staff</span>
                                            <h4><?php echo htmlentities($totaddstaff); ?></h4>
                                            <a href="add_staff.php"><span class="report-count"> Add staff</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-pink">
                                            <i class="icon-user-follow"></i>
                                        </div>
                                    </div>
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
