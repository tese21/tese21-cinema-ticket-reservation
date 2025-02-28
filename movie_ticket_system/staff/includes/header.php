<?php
session_start();
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
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo" href="staff_dashboard.php">
            <strong style="color: white;">Cinema</strong>
        </a>
        <a class="navbar-brand brand-logo-mini" href="staff_dashboard.php">
            <img src="../img/logo.png" alt="logo" />
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
        <h5 class="mb-0 font-weight-medium d-none d-lg-flex">
            <?php echo htmlspecialchars($staff['Fname']); ?>, Welcome to the dashboard!
        </h5>
        <ul class="navbar-nav navbar-nav-right ml-auto">
            <li class="nav-item d-none d-xl-inline-flex">
                <a class="nav-link" href="search.php">
                    <i class="icon-magnifier"></i> Search
                </a>
            </li>
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle ml-2" src="images/faces/face8.jpg" alt="ProfilePhoto"> 
                    <span class="font-weight-normal"> <?php echo htmlspecialchars($staff['Fname']); ?> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="images/faces/face8.jpg" alt="ProfilePhoto">
                        <p class="mb-1 mt-3"><?php echo htmlspecialchars($staff['Fname']); ?></p>
                        <p class="font-weight-light text-muted mb-0"><?php echo htmlspecialchars($staff['Email']); ?></p>
                    </div>
                    <a class="dropdown-item" href="profile.php"><i class="dropdown-item-icon icon-user text-primary"></i> My Profile</a>
                    <a class="dropdown-item" href="change-password.php"><i class="dropdown-item-icon icon-energy text-primary"></i> Settings</a>
                    <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon icon-power text-primary"></i> Sign Out</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
