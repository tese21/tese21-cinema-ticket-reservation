<?php
// Include database connection
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_staff'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $salary = $_POST['salary'];

    // Handle profile photo upload
    $profilePhoto = 'default.jpg'; // Default profile photo
    if (isset($_FILES['profilephoto']) && $_FILES['profilephoto']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../uploads/staff/";
        $targetFile = $targetDir . basename($_FILES['profilephoto']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['profilephoto']['tmp_name']);
        if ($check !== false) {
            // Check file size (limit to 5MB)
            if ($_FILES['profilephoto']['size'] <= 5000000) {
                // Allow certain file formats
                if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES['profilephoto']['tmp_name'], $targetFile)) {
                        $profilePhoto = basename($_FILES['profilephoto']['name']);
                    } else {
                        echo "<script>alert('Error uploading profile image.');</script>";
                    }
                } else {
                    echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
                }
            } else {
                echo "<script>alert('File size exceeds the limit of 5MB.');</script>";
            }
        } else {
            echo "<script>alert('File is not an image.');</script>";
        }
    }

    // Insert into user table first
    $stmt = $conn->prepare("INSERT INTO user (Fname, Lname, Email, Phone, Username, Password, Sex, Age, Role, profilephoto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Staff', ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sssssssis", $fname, $lname, $email, $phone, $username, $password, $sex, $age, $profilePhoto);

    if ($stmt->execute()) {
        $userID = $stmt->insert_id; // Get the inserted user ID

        // Insert into staff table
        $stmt = $conn->prepare("INSERT INTO staff (UserID, Salary) VALUES (?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("id", $userID, $salary);

        if ($stmt->execute()) {
            $success_message = "Staff member added successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    } else {
        $error_message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add New Staff</h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="card shadow p-4">
            <form method="POST" action="add_staff.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" required>
                </div>

                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" id="lname" name="lname" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" class="form-control" id="age" name="age" required>
                </div>

                <div class="form-group">
                    <label for="sex">Gender:</label>
                    <select id="sex" name="sex" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="number" class="form-control" id="salary" name="salary" required>
                </div>

                <div class="form-group">
                    <label for="profilephoto">Profile Photo:</label>
                    <input type="file" class="form-control" id="profilephoto" name="profilephoto" accept="image/*">
                </div>

                <button type="submit" name="add_staff" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add Staff
                </button>
                <a href="staff_list.php" class="btn btn-secondary ml-2"><i class="fas fa-arrow-left"></i> Back to Staff List</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
