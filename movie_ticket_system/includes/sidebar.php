<?php
include('../config/db.php');
$aid = $_SESSION['sturecmsaid'];

// Fetch admin details
$sql = "SELECT * FROM administrator WHERE AdminID = '$aid'";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="profile-image">
                    <img class="img-xs rounded-circle" src="../img/logo.png" alt="ProfilePhoto">
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                    <p class="profile-name"><?php echo htmlspecialchars($admin['Fname']); ?></p>
                    <p class="designation"><?php echo htmlspecialchars($admin['Email']); ?></p>
                </div>
            </a>
        </li>
        
        <li class="nav-item nav-category">
            <span class="nav-link">Dashboard</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin_dashboard.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">customer</span>
                <i class="icon-layers menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="customer_list.php">Customer list </a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <span class="menu-title">staff</span>
                <i class="icon-people menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="staff_list.php">staff list</a></li>
                    <li class="nav-item"> <a class="nav-link" href="add_staff.php">add staff</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#hw" aria-expanded="false" aria-controls="hw">
                <span class="menu-title">Movie</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="hw">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../admin/movie_list.php">movie list </a></li>
                    <li class="nav-item"> <a class="nav-link" href="../admin/add_movie.php">Add_movie</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">Notice</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="add-notice.php"> Add Notice </a></li>
                    <li class="nav-item"> <a class="nav-link" href="manage-notice.php"> Manage Notice </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1">
                <span class="menu-title">Public Notice</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="add-public-notice.php"> Add Public Notice </a></li>
                    <li class="nav-item"> <a class="nav-link" href="manage-public-notice.php"> Manage Public Notice </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth2" aria-expanded="false" aria-controls="auth2">
                <span class="menu-title">Pages</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth2">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="about.php"> About Us </a></li>
                    <li class="nav-item"> <a class="nav-link" href="contact-us.php"> Contact Us </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth22" aria-expanded="false" aria-controls="auth22">
                <span class="menu-title">Reports</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth22">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="between-dates-reports.php"> Student </a></li>
                    <li class="nav-item"> <a class="nav-link" href="bw-report-hw.php"> Homework </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="search.php">
                <span class="menu-title">Search</span>
                <i class="icon-magnifier menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
