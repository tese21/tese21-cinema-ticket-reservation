<?php
include '../config/db.php';

session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if UserID is not set in session
    header("Location: ../login.php");
    exit();
}

$userID = $_SESSION['UserID'];

if (isset($_POST['submit'])) {
    $cpassword = $_POST['currentpassword'];
    $newpassword = password_hash($_POST['newpassword'], PASSWORD_BCRYPT); // Hash the new password

    // Fetch stored password (hashed)
    $sql = "SELECT Password FROM user WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($storedPassword);
        $stmt->fetch();

        // Verify the current password
        if (password_verify($cpassword, $storedPassword)) {
            // Update new password (hashed)
            $updateSql = "UPDATE user SET Password = ? WHERE UserID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $newpassword, $userID);
            $updateStmt->execute();

            echo '<script>alert("Your password was successfully changed"); 
            window.location.href="change_password.php";</script>';
        } else {
            echo '<script>alert("Your current password is incorrect");</script>';
        }
    } else {
        echo '<script>alert("Error: User ID not found");</script>';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Management System | Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
<body class="bg-gray-900 text-white min-h-screen flex flex-col">
    <?php include_once('header.php'); ?>
    <div class="flex-grow flex items-center justify-center">
        <div class="container mx-auto p-4">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
                <h3 class="text-2xl font-bold text-center mb-4">Change Password</h3>
                <form class="space-y-4" name="changepassword" method="post" onsubmit="return checkpass();">
                    <div class="form-group">
                        <label for="currentpassword" class="block text-sm font-medium">Current Password</label>
                        <input type="password" id="currentpassword" name="currentpassword" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="block text-sm font-medium">New Password</label>
                        <input type="password" id="newpassword" name="newpassword" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword" class="block text-sm font-medium">Confirm Password</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
                    </div>
                    <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300" name="submit">Change</button>
                </form>
            </div>
        </div>
    </div>
    <?php include_once('../footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>