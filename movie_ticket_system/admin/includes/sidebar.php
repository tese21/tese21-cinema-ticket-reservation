<?php
include('../config/db.php');
$aid = $_SESSION['sturecmsaid'];
$sql = "SELECT a.*, u.Fname, u.Email FROM administrator a JOIN user u ON a.UserID = u.UserID WHERE a.AdminID = '$aid'";
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

        <!-- Dashboard Section -->
        <li class="nav-item nav-category">
            <span class="nav-link">Dashboard</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin_dashboard.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
            </a>
        </li>

        <!-- Customer Section -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Customer</span>
                <i class="icon-layers menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="customer_list.php">Customer List</a></li>
                
                </ul>
            </div>
        </li>

        <!-- Staff Section -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <span class="menu-title">Staff</span>
                <i class="icon-people menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="staff_list.php">Staff List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="add_staff.php">Add Staff</a></li>
                </ul>
            </div>
        </li>

        <!-- Movie Section -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#hw" aria-expanded="false" aria-controls="hw">
                <span class="menu-title">Movie</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="hw">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="movie_list.php">Movie List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="add_movie.php">Add Movie</a></li>
                </ul>
            </div>
        </li>

        <!-- Notice Section -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">Ticket</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="ticket_list.php">Ticket history</a></li>
                  
                </ul>
            </div>
        </li>

        <!-- Schedule Section -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1">
                <span class="menu-title">Schedule</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="add_schedule.php">Add Schedule</a></li>
                    <li class="nav-item"> <a class="nav-link" href="manage_schedule.php">Movie schedule</a></li>
                </ul>
            </div>
        </li>
  <!-- Reports Section -->
  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth22" aria-expanded="false" aria-controls="auth22">
                <span class="menu-title">Seat</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth22">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="add_seat.php">add_seat</a></li>
                    <li class="nav-item"> <a class="nav-link" href="view_seat.php">view_seat</a></li>
                </ul>
            </div>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth22" aria-expanded="false" aria-controls="auth22">
                <span class="menu-title">Feadback</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth22">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="feedback_list.php">Feadback</a></li>
                </ul>
            </div>
        </li>

        <!-- Search Section -->
        <li class="nav-item">
            <a class="nav-link" href="search.php">
                <span class="menu-title">Search</span>
                <i class="icon-magnifier menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
