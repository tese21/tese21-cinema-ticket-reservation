<?php
include '../config/db.php'; // Ensure this file correctly connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seat_no = $_POST['seat_no'];
    $seat_level = $_POST['seat_level'];
    $schedule_id = $_POST['schedule_id'];

    $query = "INSERT INTO available_seat (SeatNo, SeatLevel, ScheduleID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ssi", $seat_no, $seat_level, $schedule_id);

    if ($stmt->execute()) {
        $message = "Seat added successfully!";
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
    <title>Add Seat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">Add a New Seat</h2>
        <?php if (isset($message)): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="seat_no" class="block text-sm font-medium text-gray-700">Seat No:</label>
                <input type="text" id="seat_no" name="seat_no" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="seat_level" class="block text-sm font-medium text-gray-700">Seat Level:</label>
                <select id="seat_level" name="seat_level" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
                    <option value="Standard">Standard</option>
                    <option value="Premium">Premium</option>
                    <option value="VIP">VIP</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="schedule_id" class="block text-sm font-medium text-gray-700">Schedule ID:</label>
                <input type="number" id="schedule_id" name="schedule_id" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Add Seat</button>
        </form>
    </div>
</body>
</html>
