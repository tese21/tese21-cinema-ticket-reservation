<?php
include '../config/db.php'; // Include database connection

session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if UserID is not set in session
    header("Location: ../login.php");
    exit();
}

$userID = $_SESSION['UserID'];

// Fetch user details from the database
$sql = "SELECT Fname, Lname, Email, Sex, Age, Username, Phone FROM user WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $email = $_POST['Email'];
    $sex = $_POST['Sex'];
    $age = $_POST['Age'];
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];

    // Update user details in the database
    $sql = "UPDATE user SET Fname = ?, Lname = ?, Email = ?, Sex = ?, Age = ?, Username = ?, Phone = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssissi", $fname, $lname, $email, $sex, $age, $username, $phone_number, $userID);
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('../img/bacc.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.5; /* Adjust the opacity as needed */
            z-index: -1;
        }
        .form-container {
            max-height: 90vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center relative">

    <div class="form-container p-8 rounded-lg shadow-lg bg-gray-800 w-full max-w-2xl animate__animated animate__fadeIn">
        <?php include 'header.php'; ?>
        <h1 class="text-center text-3xl mb-6">Settings</h1>
        <form method="POST" action="myprofile.php">
            <div class="mb-4">
                <label for="Fname" class="block text-sm font-medium">First Name</label>
                <input type="text" id="Fname" name="Fname" value="<?php echo htmlspecialchars($user['Fname']); ?>" placeholder="First Name" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
            </div>
            <div class="mb-4">
                <label for="Lname" class="block text-sm font-medium">Last Name</label>
                <input type="text" id="Lname" name="Lname" value="<?php echo htmlspecialchars($user['Lname']); ?>" placeholder="Last Name" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
            </div>
            <div class="mb-4">
                <label for="Email" class="block text-sm font-medium">Email</label>
                <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" placeholder="Email" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
            </div>
            <div class="mb-4">
                <label for="Sex" class="block text-sm font-medium">Sex</label>
                <input type="text" id="Sex" name="Sex" value="<?php echo htmlspecialchars($user['Sex']); ?>" placeholder="Sex" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
            </div>
            <div class="mb-4">
                <label for="Age" class="block text-sm font-medium">Age</label>
                <input type="number" id="Age" name="Age" value="<?php echo htmlspecialchars($user['Age']); ?>" placeholder="Age" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" placeholder="Username" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['Phone']); ?>" placeholder="Phone Number" class="mt-1 p-2 block w-full rounded-md bg-gray-700 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-white" required>
            </div>
            <div>
                <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Update Profile</button>
            </div>
        </form>
        <div class="mt-4">
            <a href="customer_dashboard.php" class="w-full py-2 px-4 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 transition duration-300 block text-center">Back to Home Page</a>
        </div>
        <?php include '../footer.php'; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add any additional JavaScript/jQuery functionality here
        });
    </script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>

