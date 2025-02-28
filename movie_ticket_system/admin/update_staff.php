<?php
// Include the database connection
include '../config/db.php';

// Check if the staff ID is provided
if (isset($_GET['StaffID'])) {
    $staffID = intval($_GET['StaffID']); // Ensure it's an integer

    // Query to fetch the current staff details
    $sql = "SELECT s.StaffID, u.Fname, u.Lname, u.Age, u.Sex, u.Phone AS MobilePhone, u.profilephoto, s.Salary 
            FROM staff s 
            JOIN user u ON s.UserID = u.UserID 
            WHERE s.StaffID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $staffID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
    } else {
        echo "<script>alert('Staff not found!'); window.location.href='staff_list.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='staff_list.php';</script>";
    exit;
}

// Handle form submission for updating staff
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated values from the form (sanitization added)
    $fname = htmlspecialchars(trim($_POST['Fname']));
    $lname = htmlspecialchars(trim($_POST['Lname']));
    $age = intval($_POST['Age']);
    $sex = htmlspecialchars(trim($_POST['Sex']));
    $mobilephone = htmlspecialchars(trim($_POST['MobilePhone']));
    $salary = floatval($_POST['Salary']); // New Salary field

    // Handle profile photo upload
    $profilephoto = $staff['profilephoto']; // Default to current profile image
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
                        $profilephoto = basename($_FILES['profilephoto']['name']);
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

    // Update the user details in the database
    $sql = "UPDATE user u 
            JOIN staff s ON u.UserID = s.UserID 
            SET u.Fname = ?, u.Lname = ?, u.Age = ?, u.Sex = ?, u.Phone = ?, u.profilephoto = ?, s.Salary = ? 
            WHERE s.StaffID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisssdi', $fname, $lname, $age, $sex, $mobilephone, $profilephoto, $salary, $staffID);

    if ($stmt->execute()) {
        echo "<script>alert('Staff details updated successfully!'); window.location.href='staff_list.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating staff details.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        header {
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background: #218838;
        }
        .cancel-btn {
            background: #dc3545;
        }
        .cancel-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

    <header>
        <h1>Update Staff</h1>
        <a href="staff_list.php">Back to Staff List</a>
    </header>

    <main>
        <form action="update_staff.php?StaffID=<?php echo $staffID; ?>" method="post" enctype="multipart/form-data">
            <label for="Fname">First Name</label>
            <input type="text" name="Fname" value="<?php echo htmlspecialchars($staff['Fname']); ?>" required>

            <label for="Lname">Last Name</label>
            <input type="text" name="Lname" value="<?php echo htmlspecialchars($staff['Lname']); ?>" required>

            <label for="Age">Age</label>
            <input type="number" name="Age" value="<?php echo $staff['Age']; ?>" required>

            <label for="Sex">Sex</label>
            <select name="Sex">
                <option value="Male" <?php echo ($staff['Sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($staff['Sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($staff['Sex'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <label for="MobilePhone">Mobile Phone</label>
            <input type="text" name="MobilePhone" value="<?php echo htmlspecialchars($staff['MobilePhone']); ?>" required>

            <label for="profilephoto">Profile Image</label>
            <input type="file" name="profilephoto" accept="image/*">
            <img src="../uploads/staff/<?php echo htmlspecialchars($staff['profilephoto']); ?>" alt="Profile Image" class="img-thumbnail" width="100">

            <label for="Salary">Salary</label>
            <input type="number" name="Salary" step="0.01" value="<?php echo htmlspecialchars($staff['Salary']); ?>" required>

            <button type="submit">Update Staff</button>
        </form>

        <br>
        <a href="staff_list.php"><button class="cancel-btn">Cancel</button></a>
    </main>

</body>
</html>
