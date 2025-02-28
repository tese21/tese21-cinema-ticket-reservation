<?php
include('../config/db.php');


// Pagination variables
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search variables
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch all schedules with pagination and search
$schedules = [];
$query = "SELECT ms.ScheduleID, m.MovieTitle, ms.StartTime, ms.EndTime, ms.Duration, ms.amount, ms.total_seat 
          FROM movie_schedule ms 
          JOIN movie m ON ms.MovieID = m.MovieID 
          WHERE m.MovieTitle LIKE ? 
          LIMIT ?, ?";
$stmt = $conn->prepare($query);
$search_param = "%" . $search . "%";
$stmt->bind_param("sii", $search_param, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $schedules[] = $row;
}
$stmt->close();

// Get total number of records for pagination
$query = "SELECT COUNT(*) AS total FROM movie_schedule ms JOIN movie m ON ms.MovieID = m.MovieID WHERE m.MovieTitle LIKE ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
$total = $result->fetch_assoc()['total'];
$stmt->close();

$total_pages = ceil($total / $limit);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedules</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-6">View Schedules</h1>

        <form method="GET" action="manage_schedule.php" class="mb-6">
            <input type="text" name="search" placeholder="Search by Movie Title" value="<?php echo htmlspecialchars($search); ?>" class="p-2 rounded border border-gray-300">
            <button type="submit" class="p-2 bg-blue-500 text-white rounded">Search</button>
        </form>

        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Movie Title</th>
                    <th class="py-2 px-4 border-b">Start Time</th>
                    <th class="py-2 px-4 border-b">End Time</th>
                    <th class="py-2 px-4 border-b">Duration</th>
                    <th class="py-2 px-4 border-b">Amount</th>
                    <th class="py-2 px-4 border-b">Total Seats</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($schedule['MovieTitle']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($schedule['StartTime']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($schedule['EndTime']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($schedule['Duration']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($schedule['amount']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($schedule['total_seat']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="edit_schedule.php?schedule_id=<?php echo $schedule['ScheduleID']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Edit</a>
                            <a href="delete_schedule.php?schedule_id=<?php echo $schedule['ScheduleID']; ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-6">
            <?php if ($page > 1): ?>
                <a href="manage_schedule.php?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>" class="p-2 bg-gray-300 text-black rounded">Previous</a>
            <?php endif; ?>

            <?php if ($page < $total_pages): ?>
                <a href="manage_schedule.php?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>" class="p-2 bg-gray-300 text-black rounded">Next</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>