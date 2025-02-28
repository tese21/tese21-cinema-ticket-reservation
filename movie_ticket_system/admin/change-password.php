<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $adminid = $_SESSION['sturecmsaid'];
    $cpassword = $_POST['currentpassword'];
    $newpassword = password_hash($_POST['newpassword'], PASSWORD_BCRYPT); // Hash the new password

    // Fetch UserID from administrator table
    $sql = "SELECT UserID FROM administrator WHERE AdminID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $adminid);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid);
        $stmt->fetch();

        // Fetch stored password (hashed) from the user table
        $sql = "SELECT Password FROM user WHERE UserID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($storedPassword);
            $stmt->fetch();

            // Verify the current password
            if (password_verify($cpassword, $storedPassword)) {
                // Update new password (hashed) in the user table
                $updateSql = "UPDATE user SET Password=? WHERE UserID=?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("si", $newpassword, $userid);
                $updateStmt->execute();

                echo '<script>alert("Your password was successfully changed"); 
                window.location.href="change-password.php";</script>';
            } else {
                echo '<script>alert("Your current password is incorrect");</script>';
            }
        } else {
            echo '<script>alert("Error: User ID not found");</script>';
        }
    } else {
        echo '<script>alert("Error: Admin ID not found");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management System | Change Password</title>
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/styles.css" />
    <script type="text/javascript">
        function checkpass() {
            let form = document.forms["changepassword"];
            if (form["newpassword"].value !== form["confirmpassword"].value) {
                alert('New Password and Confirm Password fields do not match');
                form["confirmpassword"].focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Change Password</h3>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">Change Password</h4>
                                <form class="forms-sample" name="changepassword" method="post" onsubmit="return checkpass();">
                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <input type="password" name="currentpassword" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="newpassword" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirmpassword" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Change</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
</div>
<script src="vendors/js/vendor.bundle.base.js"></script>
</body>
</html>
