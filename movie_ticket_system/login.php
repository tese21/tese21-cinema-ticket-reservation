<?php
// Include database connection
include 'config/db.php';

// Start session at the top of the script
session_start();

// Handle form submission
$error = ''; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if the user is a staff (user table with Role = 'Staff')
    $query = "SELECT u.UserID, u.Password, u.Role, s.StaffID FROM user u JOIN staff s ON u.UserID = s.UserID WHERE u.Username = ? AND u.Role = 'Staff'";
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        error_log('SQL Error: ' . $conn->error); // Log error
        die('Error preparing the SQL query.');
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Valid staff login
        $staff = $result->fetch_assoc();
        
        // Log the fetched password hash for debugging
        error_log("Fetched password hash for username $username: " . $staff['Password']);
        
        // Verify the password
        if (password_verify($password, $staff['Password'])) {
            $_SESSION['role'] = 'Staff';
            $_SESSION['UserID'] = $staff['UserID']; // Store UserID in session
            $_SESSION['StaffID'] = $staff['StaffID']; // Store StaffID in session
            session_regenerate_id(true); // Prevent session fixation
            header("Location: staff/staff_dashboard.php"); // Redirect to staff dashboard
            exit();
        } else {
            error_log("Password mismatch for username: " . $username); // Log the error
            $error = "Invalid staff credentials.";
        }
    } else {
        // Check if the user is a customer (user table)
        $query = "SELECT * FROM user WHERE Username = ? AND Role = 'Customer'";
        
        // Use prepared statements to avoid SQL injection
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            error_log('SQL Error: ' . $conn->error); // Log error
            die('Error preparing the SQL query.');
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Valid customer login
            $customer = $result->fetch_assoc();
            
            // Verify the password
            if (password_verify($password, $customer['Password'])) {
                $_SESSION['role'] = 'Customer';
                $_SESSION['UserID'] = $customer['UserID']; // Store UserID in session
                session_regenerate_id(true); // Prevent session fixation
                header("Location: customer/customer_dashboard.php"); // Redirect to customer dashboard
                exit();
            } else {
                $error = "Invalid customer credentials.";
            }
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-800">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <img src="img/us.jpg" alt="Logo" class="w-32 h-32 mx-auto rounded-full mb-4">

        <?php if (!empty($error)) : ?>
            <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <input type="submit" value="Sign In" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 cursor-pointer">
            </div>

            <p class="text-center text-gray-600"><a href="#" class="hover:underline">Forgot Password</a></p>
        </form>

        <div class="text-center mt-4">
            <p class="text-gray-600">Don't have an account? <a href="customer/register.php" class="text-blue-500 hover:underline">Register Here</a></p>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>