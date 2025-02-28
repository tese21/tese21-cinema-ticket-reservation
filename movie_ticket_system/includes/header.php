<?php
include('../config/db.php');
$aid = $_SESSION['sturecmsaid'];

// Fetch admin details
$sql = "SELECT * FROM administrator WHERE AdminID = '$aid'";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();
?>
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo" href="admin_dashboard.php">
            <strong style="color: white;">Cinema</strong>
        </a>
        <a class="navbar-brand brand-logo-mini" href="admin_dashboard.php">
            <img src="img/logo.png" alt="logo" />
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
        <h5 class="mb-0 font-weight-medium d-none d-lg-flex">
            <?php echo htmlspecialchars($admin['Fname']); ?> Welcome dashboard!
        </h5>
        <ul class="navbar-nav navbar-nav-right ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle ml-2" src="images/faces/face8.jpg" alt="ProfilePhoto"> 
                    <span class="font-weight-normal"> <?php echo htmlspecialchars($admin['Fname']); ?> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="images/faces/face8.jpg" alt="ProfilePhoto">
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
