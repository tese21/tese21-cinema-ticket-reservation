<?php
include('../config/db.php');

// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$aid = $_SESSION['sturecmsaid'];

// Fetch admin details
$sql = "SELECT a.*, u.Fname, u.Email, u.profilephoto FROM administrator a JOIN user u ON a.UserID = u.UserID WHERE a.AdminID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aid);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any results
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    // Handle the case when no results are found, for example, redirect to an error page
    header('Location: error_page.php');
    exit();
}
$stmt->close();

// Debugging: Check if ProfilePhoto is set
if (empty($admin['profilephoto'])) {
    $admin['profilephoto'] = 'default.jpg'; // Set a default profile photo if not set
}

// Debugging: Check if the profile photo file exists
$profilePhotoPath = "../img/" . htmlspecialchars($admin['profilephoto']);
if (!file_exists($profilePhotoPath)) {
    $profilePhotoPath = "../img/default.jpg"; // Use a default profile photo if the file does not exist
}
?>

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo" href="admin_dashboard.php">
            <strong style="color: white;">Cinema</strong>
        </a>
        <a class="navbar-brand brand-logo-mini" href="admin_dashboard.php">
            <img src="../img/logo.png" alt="logo" />
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
        <h5 class="mb-0 font-weight-medium d-none d-lg-flex">
            <?php echo htmlspecialchars($admin['Fname']); ?>, Welcome to the Admin Dashboard!
        </h5>
        <ul class="navbar-nav navbar-nav-right ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle ml-2" src="<?php echo $profilePhotoPath; ?>" alt="ProfilePhoto"> 
                    <span class="font-weight-normal"> <?php echo htmlspecialchars($admin['Fname']); ?> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="<?php echo $profilePhotoPath; ?>" alt="ProfilePhoto">
                        <p class="mb-1 mt-3"><?php echo htmlspecialchars($admin['Fname']); ?></p>
                        <p class="font-weight-light text-muted mb-0"><?php echo htmlspecialchars($admin['Email']); ?></p>
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
