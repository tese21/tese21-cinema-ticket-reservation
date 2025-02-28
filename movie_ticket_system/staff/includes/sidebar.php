<?php
include('../config/db.php');

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['UserID']) || $_SESSION['role'] != 'Staff') {
    header('location:../login.php');
    exit();
}

$staffID = $_SESSION['UserID'];

// Fetch staff details
$sql = "SELECT u.Fname, u.Email FROM user u JOIN staff s ON u.UserID = s.UserID WHERE u.UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any results
if ($result->num_rows > 0) {
    $staff = $result->fetch_assoc();
} else {
    // Handle the case when no results are found
    $staff = ['Fname' => 'Unknown', 'Email' => 'Unknown'];
}
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
                    <p class="profile-name"><?php echo htmlspecialchars($staff['Fname']); ?></p>
                    <p class="designation"><?php echo htmlspecialchars($staff['Email']); ?></p>
                </div>
            </a>
        </li>
        
        <li class="nav-item nav-category">
            <span class="nav-link">Dashboard</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="staff_dashboard.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Customers</span>
                <i class="icon-layers menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../admin/customer_list.php">Customer List</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#movie" aria-expanded="false" aria-controls="movie">
                <span class="menu-title">Movies</span>
                <i class="icon-film menu-icon"></i>
            </a>
            <div class="collapse" id="movie">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../admin/movie_list.php">Movie List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../admin/add_movie.php">Add Movie</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#schedule" aria-expanded="false" aria-controls="schedule">
                <span class="menu-title">Schedules</span>
                <i class="icon-calendar menu-icon"></i>
            </a>
            <div class="collapse" id="schedule">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../admin/manage_schedule.php">Schedule List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../admin/add_schedule.php">Add Schedule</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">Ticket</span>
                <i class="icon-doc menu-icon"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../admin/ticket_list.php">Ticket history</a></li>
                    
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
