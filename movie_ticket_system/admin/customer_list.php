<?php
// Include the database connection
include '../config/db.php'; // Adjust the filename if necessary

// Handle search input
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Pagination logic
$limit = 7; // Number of entries to show in a page.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of records
$total_query = "SELECT COUNT(*) FROM user WHERE Role = 'Customer'";
if ($search != '') {
    $total_query .= " AND (Email LIKE '%$search%' OR Phone LIKE '%$search%' OR Username LIKE '%$search%')";
}
$total_result = mysqli_query($conn, $total_query);
$total_records = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_records / $limit);

// Fetch customers from the database with pagination
$sql = "SELECT UserID, Fname, Lname, Email, Phone, Username, Sex, Age, RegistrationDate 
        FROM user 
        WHERE Role = 'Customer'";
if ($search != '') {
    $sql .= " AND (Email LIKE '%$search%' OR Phone LIKE '%$search%' OR Username LIKE '%$search%')";
}
$sql .= " LIMIT $start, $limit";
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
    <title>Customer List</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto py-10 px-3">
        <h1 class="text-3xl font-bold text-center mb-6 text-yellow-400">Customer List</h1>
        
        <form method="post" action="">
            <div class="mb-4">
                <input type="text" name="search" class="p-2 w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700" placeholder="Search by Email, Phone, or Username" value="<?php echo htmlentities($search); ?>">
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Search</button>
        </form>

        <div class="table-responsive mt-6">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/12 py-2">UserID</th>
                        <th class="w-2/12 py-2">First Name</th>
                        <th class="w-2/12 py-2">Last Name</th>
                        <th class="w-2/12 py-2">Email</th>
                        <th class="w-2/12 py-2">Phone</th>
                        <th class="w-2/12 py-2">Username</th>
                        <th class="w-1/12 py-2">Sex</th>
                        <th class="w-1/12 py-2">Age</th>
                        <th class="w-2/12 py-2">Registration Date</th>
                        <th class="w-2/12 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td class='border px-4 py-2'>{$row['UserID']}</td>
                                <td class='border px-4 py-2'>{$row['Fname']}</td>
                                <td class='border px-4 py-2'>{$row['Lname']}</td>
                                <td class='border px-4 py-2'>{$row['Email']}</td>
                                <td class='border px-4 py-2'>{$row['Phone']}</td>
                                <td class='border px-4 py-2'>{$row['Username']}</td>
                                <td class='border px-4 py-2'>{$row['Sex']}</td>
                                <td class='border px-4 py-2'>{$row['Age']}</td>
                                <td class='border px-4 py-2'>{$row['RegistrationDate']}</td>
                                <td class='border px-4 py-2'>
                                    <a href='update_customer.php?UserID={$row['UserID']}' class='text-green-600 hover:text-green-800'>
                                        <i class='fas fa-edit'></i> Update
                                    </a>
                                    <a href='delete_customer.php?UserID={$row['UserID']}' class='text-red-600 hover:text-red-800 ml-2' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>
                                        <i class='fas fa-trash'></i> Delete
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center py-4'>No customers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination controls -->
        <div class="flex justify-center mt-6">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <a href="?page=<?php echo max(1, $page - 1); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span>Previous</span>
                </a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $i == $page ? 'text-yellow-500' : 'text-gray-500'; ?> hover:bg-gray-50">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                <a href="?page=<?php echo min($total_pages, $page + 1); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span>Next</span>
                </a>
            </nav>
        </div>

        <a href="admin_dashboard.php" class="mt-6 inline-block py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-300"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</body>
</html>