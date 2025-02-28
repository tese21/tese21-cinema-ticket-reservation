<?php
include '../config/db.php'; // Ensure this file correctly connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $duration = $_POST['duration'];
    $amount = $_POST['amount'];
    $total_seat = $_POST['total_seat'];

    $query = "INSERT INTO movie_schedule (MovieID, StartTime, EndTime, Duration, amount, total_seat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("isssdi", $movie_id, $start_time, $end_time, $duration, $amount, $total_seat);

    if ($stmt->execute()) {
        $message = "Schedule added successfully!";
    } else {
        $message = "Error: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">Add a New Schedule</h2>
        <?php if (isset($message)): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="movie_id" class="block text-sm font-medium text-gray-700">Movie ID:</label>
                <input type="number" id="movie_id" name="movie_id" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time:</label>
                <input type="datetime-local" id="start_time" name="start_time" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time:</label>
                <input type="datetime-local" id="end_time" name="end_time" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="duration" class="block text-sm font-medium text-gray-700">Duration:</label>
                <input type="text" id="duration" name="duration" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount:</label>
                <input type="number" step="0.01" id="amount" name="amount" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="total_seat" class="block text-sm font-medium text-gray-700">Total Seats:</label>
                <input type="number" id="total_seat" name="total_seat" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Add Schedule</button>
        </form>
    </div>
</body>
</html>