<?php
// Include database connection
include '../config/db.php';

// Handle form submission for customer registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing password
    $phone_number = $_POST['phone_number'];

    // Check if the email already exists
    $check_email_sql = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                The email address '$email' is already in use. Please choose a different email.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } else {
        // Insert into user table
        $query = "INSERT INTO user (Fname, Lname, Email, Phone, Username, Password, Sex, Age, Role) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Customer')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $fname, $lname, $email, $phone_number, $username, $password, $sex, $age);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Customer registered successfully! You will be redirected to the login page.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
            // Redirect after 3 seconds to the login page
            header("refresh:3;url=../login.php");
            exit();
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Error: " . $conn->error . "<br> Please try again later.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .container {
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="container bg-white p-8 rounded-lg shadow-lg animate__animated animate__fadeIn">
        <header class="text-center mb-4">
            <h1 class="text-2xl font-bold">Customer Registration</h1>
            <a href="../index.php" class="text-blue-500 hover:underline">Back to Home</a>
        </header>

        <form method="POST" action="register.php">
            <div class="mb-4">
                <label for="fname" class="block text-sm font-medium">First Name</label>
                <input type="text" id="fname" name="fname" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" placeholder="Enter your first name" required>
            </div>

            <div class="mb-4">
                <label for="lname" class="block text-sm font-medium">Last Name</label>
                <input type="text" id="lname" name="lname" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" placeholder="Enter your last name" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" placeholder="Enter your email address" required>
            </div>

            <div class="mb-4">
                <label for="sex" class="block text-sm font-medium">Gender</label>
                <select id="sex" name="sex" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="age" class="block text-sm font-medium">Age</label>
                <input type="number" id="age" name="age" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" placeholder="Enter your age" required>
            </div>

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" placeholder="Choose a username" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" id="password" name="password" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" placeholder="Enter a password" required>
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="mt-1 p-2 block w-full rounded-md bg-gray-200 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-900" placeholder="Enter your phone number" required>
            </div>

            <button type="submit" name="register" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Register</button>
        </form>
    </div>

    <!-- Tailwind CSS and JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
    <!-- Font Awesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <!-- Animate.css for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.js"></script>
</body>
</html>
