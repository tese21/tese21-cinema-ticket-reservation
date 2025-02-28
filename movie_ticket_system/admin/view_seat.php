<?php
include '../config/db.php'; // Ensure this file correctly connects to your database

// Pagination logic
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of records
$total_query = "SELECT COUNT(*) FROM available_seat";
$total_result = mysqli_query($conn, $total_query);
$total_records = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_records / $limit);

// Fetch seats from the database with pagination
$query = "SELECT * FROM available_seat LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Seats</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">Available Seats</h2>
        <div class="table-responsive">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/12 py-2">Seat ID</th>
                        <th class="w-2/12 py-2">Seat No</th>
                        <th class="w-2/12 py-2">Seat Level</th>
                        <th class="w-2/12 py-2">Schedule ID</th>
                        <th class="w-2/12 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $row['SeatID']; ?></td>
                        <td class="border px-4 py-2"><?= $row['SeatNo']; ?></td>
                        <td class="border px-4 py-2"><?= $row['SeatLevel']; ?></td>
                        <td class="border px-4 py-2"><?= $row['ScheduleID']; ?></td>
                        <td class="border px-4 py-2">
                            <a href="edit_seat.php?id=<?= $row['SeatID']; ?>" class="text-blue-600 hover:text-blue-800">Edit</a> | 
                            <a href="delete_seat.php?id=<?= $row['SeatID']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
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
    </div>
</body>
</html>
