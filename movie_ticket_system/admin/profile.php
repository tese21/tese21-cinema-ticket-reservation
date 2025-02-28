<?php
session_start();
error_reporting(0);
include('../config/db.php');
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $adminid = $_SESSION['sturecmsaid'];
        $AName = $_POST['adminname'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];

        // Update the user table
        $sql = "UPDATE user u JOIN administrator a ON u.UserID = a.UserID SET u.Fname=?, u.Phone=?, u.Email=? WHERE a.AdminID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $AName, $mobno, $email, $adminid);
        $stmt->execute();

        echo '<script>alert("Your profile has been updated")</script>';
        echo "<script>window.location.href ='profile.php'</script>";
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Management System | Profile</title>
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Admin Profile</h3>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">Admin Profile</h4>
                                <form class="forms-sample" method="post">
                                    <?php
                                    $sql = "SELECT a.*, u.Fname, u.Lname, u.Username, u.Email, u.Phone FROM administrator a JOIN user u ON a.UserID = u.UserID WHERE a.AdminID=?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $_SESSION['sturecmsaid']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($row = $result->fetch_assoc()) { ?>
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="adminname" value="<?php echo htmlspecialchars($row['Fname']); ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" value="<?php echo htmlspecialchars($row['Lname']); ?>" readonly class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>User Name</label>
                                            <input type="text" name="username" value="<?php echo htmlspecialchars($row['Username']); ?>" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" name="mobilenumber" value="<?php echo htmlspecialchars($row['Phone']); ?>" class="form-control" maxlength='10' required pattern="[0-9]+">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" value="<?php echo htmlspecialchars($row['Email']); ?>" class="form-control" required>
                                        </div>
                                    <?php } ?>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
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
<?php } ?>
