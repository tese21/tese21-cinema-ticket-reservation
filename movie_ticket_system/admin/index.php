<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/db.php';

$error_message = '';
if (isset($_POST['admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT a.AdminID, u.Password FROM administrator a JOIN user u ON a.UserID = u.UserID WHERE u.Username = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($adminID, $hashedPassword);
            $stmt->fetch();
            
            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['sturecmsaid'] = $adminID;
                session_regenerate_id(true);
                if (!empty($_POST["remember"])) {
                    setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60)); // Store username
                    setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60)); // Store password (not recommended for security reasons)
                } else {
                    if (isset($_COOKIE["user_login"])) {
                        setcookie("user_login", "", time() - 3600);
                    }
                    if (isset($_COOKIE["userpassword"])) {
                        setcookie("userpassword", "", time() - 3600);
                    }
                }
                $_SESSION['admin'] = $username;
                header('Location: admin_dashboard.php');
                exit();
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all fields.";
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
    <img class="logo" src="../img/as.jpg" alt="Admin Logo">
    <p class="lead pageAdmin">Admin Panel</p>
    <input class="form-control" type="text" name="username" placeholder="User ID" autocomplete="off" required />
    <input class="form-control" type="password" name="password" placeholder="User Password" autocomplete="new-password" required />
    <input class="btn-danger btn-block btn-lg" type="submit" value="LOGIN" name="admin"/>
</form>
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/misc.js"></script>
</body>
</html>