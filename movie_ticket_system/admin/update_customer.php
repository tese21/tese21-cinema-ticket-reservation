<?php
// Include database connection
include '../config/db.php'; 

// Check if UserID is set in URL
if (isset($_GET['UserID'])) {
    $customer_id = $_GET['UserID'];

    // Fetch customer details from the database
    $sql = "SELECT * FROM user WHERE UserID = ? AND Role = 'Customer'";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if (!$customer) {
        echo "Customer not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $username = $_POST['Username'];
    $sex = $_POST['Sex'];
    $age = $_POST['Age'];

    // Update query
    $update_sql = "UPDATE user SET Fname=?, Lname=?, Email=?, Phone=?, Username=?, Sex=?, Age=? WHERE UserID=? AND Role='Customer'";
    $update_stmt = $conn->prepare($update_sql);
    if ($update_stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $update_stmt->bind_param("ssssssii", $fname, $lname, $email, $phone, $username, $sex, $age, $customer_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Customer updated successfully!'); window.location.href='customer_list.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">Update Customer</h2>
        <form method="POST" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="Fname" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" id="Fname" name="Fname" value="<?= htmlspecialchars($customer['Fname']) ?>" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="Lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" id="Lname" name="Lname" value="<?= htmlspecialchars($customer['Lname']) ?>" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="Email" name="Email" value="<?= htmlspecialchars($customer['Email']) ?>" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="Phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="Phone" name="Phone" value="<?= htmlspecialchars($customer['Phone']) ?>" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="Username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="Username" name="Username" value="<?= htmlspecialchars($customer['Username']) ?>" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="Sex" class="block text-sm font-medium text-gray-700">Sex</label>
                <select id="Sex" name="Sex" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
                    <option value="Male" <?= $customer['Sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $customer['Sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="Age" class="block text-sm font-medium text-gray-700">Age</label>
                <input type="number" id="Age" name="Age" value="<?= htmlspecialchars($customer['Age']) ?>" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Update</button>
        </form>
    </div>
</body>
</html>
