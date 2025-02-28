<?php
// Start the session
session_start();

// Include database connection
include '../config/db.php';

// Get the logged-in user's ID from the session
$userID = $_SESSION['UserID'];

// Pagination logic
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query to fetch the user's transaction history from the database with pagination
$sql = "SELECT t.TransactionID, t.tx_ref, t.Amount, t.TransactionDate, m.MovieTitle, s.SeatNo 
        FROM transactions t 
        JOIN movie m ON t.MovieID = m.MovieID 
        JOIN available_seat s ON t.SeatID = s.SeatID 
        WHERE t.UserID = ? 
        ORDER BY t.TransactionDate DESC 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $userID, $limit, $offset); // Bind the user ID, limit, and offset to the query
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Query to get the total number of records
$total_sql = "SELECT COUNT(*) AS total FROM transactions WHERE UserID = ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("i", $userID);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_stmt->close();

$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket History</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center min-h-screen text-white" style="background-image: url('../img/bacc.jpg'); background-attachment: fixed;">

<?php include 'header.php'; // Include header or navigation ?>

<div class="bg-black bg-opacity-80 p-8 rounded-lg max-w-5xl mx-auto mt-12 shadow-lg">
    <h1 class="text-center text-3xl mb-6">Your Ticket History</h1>

    <?php if ($result->num_rows > 0) : ?>
        <!-- Display transaction history in a table -->
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-700">
                    <th class="text-left px-4 py-2">Transaction Reference</th>
                    <th class="text-left px-4 py-2">Movie Title</th>
                    <th class="text-left px-4 py-2">Seat Number</th>
                    <th class="text-left px-4 py-2">Amount</th>
                    <th class="text-left px-4 py-2">Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr class="bg-gray-800 hover:bg-gray-600">
                        <td class="px-4 py-2"><?php echo htmlspecialchars($row['tx_ref']); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($row['MovieTitle']); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($row['SeatNo']); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($row['Amount']); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($row['TransactionDate']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination buttons -->
        <div class="flex justify-between mt-4">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Previous</a>
            <?php endif; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Next</a>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <p class="text-center text-gray-300 mt-4">No transactions found for this user.</p>
    <?php endif; ?>
</div>

</body>
</html>
<?php
// Close the database connection
$conn->close();
?>