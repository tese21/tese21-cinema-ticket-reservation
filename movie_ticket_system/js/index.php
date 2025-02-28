<?php
// Include database connection
include '../config/db.php';

session_start();

// Initialize variables for error handling
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are not empty
    if (empty($username) || empty($password)) {
        $error_message = "Please enter username and password.";
    } else {
        // Query to check for matching admin credentials
        $sql = "SELECT * FROM administrator WHERE username= ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $username, $password); // Bind parameters (string and integer)
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Valid credentials, log in the admin
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Invalid credentials
            $error_message = "Username or Password is incorrect. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background-image: url("https://preview.ibb.co/kS18gQ/background_img.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            display: flex;
            justify-content: center; /* Centers horizontally */
            align-items: center;    /* Centers vertically */
        }

        form.login {
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            text-align: center; /* Center-align form content */
        }

        form.login img.logo {
            width: 150px; /* Adjust logo size */
            height: auto;
            margin-bottom: 20px; /* Space between logo and the rest of the form */
        }

        form.login .form-control {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            height: 40px;
            width: 100%;
            background-color: transparent;
            border: solid 1px black;
            color: #2e0ad4;
            font-weight: bold;
            font-family: "monospace";
            font-size: 18px;
            transition: 0.3s ease;
        }

        form.login .form-control:hover {
            transform: scale(1.05);
            border: solid 2px #3d7979;
        }

        form.login .btn-danger {
            width: 100%;
            height: 45px;
            margin-top: 10px;
            border-radius: 8px;
            letter-spacing: 2px;
            background-color: black;
            border: solid 2px black;
            transition: 0.3s ease;
            font-family: "monospace";
            font-size: 18px;
            opacity: 0.9;
            color:white;
            font-weight: bold;
            cursor: pointer;
        }

        form.login .btn-danger:hover {
            background-color:  #ff9900;
            color: white;
            letter-spacing: 5px;
            font-weight: bolder;
        }

        form.login ::placeholder {
            padding-left: 10px;
            font-size: 14px;
            letter-spacing: 1px;
            color: gray;
        }

        form.login .pageAdmin {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 20px;
            color: #000;
        }
    </style>
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <script>
            alert("<?php echo $error_message; ?>");
        </script>
    <?php endif; ?>
    
    <form class="login" method="POST" action="">
        <!-- Add logo image -->
        <img class="logo" src="../img/as.jpg" alt="Admin Logo">
        <p class="lead pageAdmin">Admin Panel</p>
        <input class="form-control" type="text" name="username" placeholder="User ID" autocomplete="off" />
        <input class="form-control" type="password" name="password" placeholder="User Password" autocomplete="new-password" />
        <input class="btn-danger btn-block btn-lg" type="submit" value="LOGIN" />
    </form>
</body>
</html>
