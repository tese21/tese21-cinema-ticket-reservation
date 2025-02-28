<?php
session_start();
include('../config/db.php');

// Check if the user is logged in and has the appropriate role


// Handle search input
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Pagination variables
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch tickets from the database with search and pagination
$sql = "SELECT t.TransactionID, u.Fname, u.Lname, m.MovieTitle, s.SeatNo, t.Amount, t.payment_method, t.status, t.tx_ref 
        FROM transactions t
        JOIN user u ON t.UserID = u.UserID
        JOIN movie m ON t.MovieID = m.MovieID
        JOIN available_seat s ON t.SeatID = s.SeatID";
if ($search != '') {
    $sql .= " WHERE t.tx_ref LIKE '%$search%'";
}
$sql .= " LIMIT $start, $limit";
$query = mysqli_query($conn, $sql);

if ($query === false) {
    // If query fails, log the error
    die('Error executing query: ' . mysqli_error($conn));
}

// Get total number of records for pagination
$total_query = "SELECT COUNT(*) AS total 
                FROM transactions t
                JOIN user u ON t.UserID = u.UserID
                JOIN movie m ON t.MovieID = m.MovieID
                JOIN available_seat s ON t.SeatID = s.SeatID";
if ($search != '') {
    $total_query .= " WHERE t.tx_ref LIKE '%$search%'";
}
$total_result = mysqli_query($conn, $total_query);
$total = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ticket List - Movie Ticket Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-10 px-3">
    <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">Ticket List</h2>
    <form method="post" action="" class="mb-6">
        <div class="flex items-center">
            <input type="text" name="search" class="form-control p-2 rounded border border-gray-300 flex-grow" placeholder="Search by Transaction Reference" value="<?php echo htmlentities($search); ?>">
            <button type="submit" class="btn btn-primary ml-2 p-2 bg-blue-500 text-white rounded">Search</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Transaction ID</th>
                    <th class="py-2 px-4 border-b">User Name</th>
                    <th class="py-2 px-4 border-b">Movie Title</th>
                    <th class="py-2 px-4 border-b">Seat No</th>
                    <th class="py-2 px-4 border-b">Amount</th>
                    <th class="py-2 px-4 border-b">Payment Method</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Transaction Reference</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['TransactionID']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['Fname'] . ' ' . $row['Lname']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['MovieTitle']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['SeatNo']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['Amount']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['payment_method']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['status']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlentities($row['tx_ref']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-6 flex justify-between">
        <?php if ($page > 1): ?>
            <a href="ticket_list.php?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>" class="p-2 bg-gray-300 text-black rounded">Previous</a>
        <?php endif; ?>

        <?php if ($page < $total_pages): ?>
            <a href="ticket_list.php?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>" class="p-2 bg-gray-300 text-black rounded">Next</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>