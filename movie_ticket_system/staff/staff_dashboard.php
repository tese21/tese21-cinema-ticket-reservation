<?php
session_start();
include('../config/db.php');

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['UserID'])) {
    header('location:logout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Staff Dashboard - Movie Ticket Reservation</title>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-sm-flex align-items-baseline report-summary-header">
                                            <h5 class="font-weight-semibold">Report Summary</h5>
                                            
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
                                            <a href="../admin/movie_list.php"><span class="report-count"> View movie</span></a>
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
                                            <a href="../admin/customer_list.php"><span class="report-count"> customer list</span></a>
                                        </div>
                                        
                                    </div>                                  
                                        <div class="inner-card-icon bg-warning">
                                            <i class="icon-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <hr />
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
                                            <a href="../admin/ticket_list.php"><span class="report-count"> View tickets</span></a>
                                        </div>
                                        <div class="inner-card-icon bg-info">
                                            <i class="icon-doc"></i>
                                        </div>
                                    </div>
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
                                            <a href="../admin/add_schedule.php"><span class="report-count"> Add schedules</span></a>
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
                                            <a href="../admin/manage_schedule.php"><span class="report-count"> View movie schedules</span></a>
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
