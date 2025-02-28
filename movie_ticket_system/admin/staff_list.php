<?php
// Include the database connection
include '../config/db.php'; // Adjust the filename if necessary

// Handle search input
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Query to select all rows from the staff table and join with the user table
$sql = "SELECT s.StaffID, u.Fname, u.Lname, u.Age, u.Sex, u.Phone AS MobilePhone, u.profilephoto, s.Salary 
        FROM staff s 
        JOIN user u ON s.UserID = u.UserID";
if ($search != '') {
    $sql .= " WHERE s.StaffID LIKE '%$search%' OR u.Fname LIKE '%$search%' OR u.Lname LIKE '%$search%' OR u.Age LIKE '%$search%' OR u.Sex LIKE '%$search%' OR u.Phone LIKE '%$search%'";
}
$result = $conn->query($sql);

// Check for query execution errors
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style.css.map">
</head>
<body class="bg-light">
    <div class="container my-4">
        <h1 class="text-center mb-4">Staff List</h1>
        
        <form method="post" action="">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Staff ID, First Name, Last Name, Age, Sex, or Mobile Phone" value="<?php echo htmlentities($search); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Staff ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Mobile Phone</th>
                        <th>Profile Image</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $profilephotoPath = '../uploads/staff/' . htmlspecialchars($row['profilephoto']);
                            if (!file_exists($profilephotoPath) || empty($row['profilephoto'])) {
                                $profilephotoPath = '../img/default.jpg'; // Use a default profile photo if the file does not exist or is not set
                            }
                            echo "<tr>
                                <td>{$row['StaffID']}</td>
                                <td>{$row['Fname']}</td>
                                <td>{$row['Lname']}</td>
                                <td>{$row['Age']}</td>
                                <td>{$row['Sex']}</td>
                                <td>{$row['MobilePhone']}</td>
                                <td><img src='{$profilephotoPath}' alt='Profile Image' class='img-thumbnail' width='50'></td>
                                <td>{$row['Salary']}</td>
                                <td>
                                    <a href='update_staff.php?StaffID={$row['StaffID']}' class='btn btn-success btn-sm'>
                                        <i class='fas fa-edit'></i> Update
                                    </a>
                                    <a href='delete_staff.php?StaffID={$row['StaffID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this staff member?\")'>
                                        <i class='fas fa-trash'></i> Delete
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No staff found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <a href="admin_dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>