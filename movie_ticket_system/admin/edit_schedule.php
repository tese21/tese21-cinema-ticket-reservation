<?php
include('../config/db.php');


$error_message = '';
$success_message = '';

// Get the schedule ID from the query parameter
$scheduleID = isset($_GET['schedule_id']) ? intval($_GET['schedule_id']) : 0;

// Fetch the schedule details
$stmt = $conn->prepare("SELECT * FROM movie_schedule WHERE ScheduleID = ?");
if ($stmt === false) {
    $error_message = "Error preparing the statement: " . $conn->error;
} else {
    $stmt->bind_param("i", $scheduleID);
    $stmt->execute();
    $schedule_result = $stmt->get_result();
    $schedule = $schedule_result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movieID = $_POST['movie_id'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $duration = $_POST['duration'];
    $amount = $_POST['amount'];
    $totalSeat = $_POST['total_seat'];

    // Validate input data
    if (empty($movieID) || empty($startTime) || empty($endTime) || empty($duration) || empty($amount) || empty($totalSeat)) {
        $error_message = "All fields are required.";
    } else {
        // Update the schedule in the database
        $stmt = $conn->prepare("UPDATE movie_schedule SET MovieID = ?, StartTime = ?, EndTime = ?, Duration = ?, amount = ?, total_seat = ? WHERE ScheduleID = ?");
        if ($stmt === false) {
            $error_message = "Error preparing the statement: " . $conn->error;
        } else {
            $stmt->bind_param("isssdii", $movieID, $startTime, $endTime, $duration, $amount, $totalSeat, $scheduleID);
            if ($stmt->execute()) {
                $success_message = "Schedule updated successfully!";
            } else {
                $error_message = "Database error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Fetch movie list for the dropdown
$movie_query = "SELECT * FROM movie";
$movie_result = $conn->query($movie_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container bg-white p-8 rounded-lg shadow-lg w-full max-w-md animate__animated animate__fadeIn">
        <h2 class="text-2xl font-bold mb-6">Edit Schedule</h2>
        <?php if ($error_message): ?>
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form action="edit_schedule.php?schedule_id=<?php echo $scheduleID; ?>" method="POST">
            <div class="mb-4">
                <label for="movie_id" class="block text-sm font-medium text-gray-700">Select Movie</label>
                <select name="movie_id" id="movie_id" class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700" required>
                    <?php while ($movie = $movie_result->fetch_assoc()): ?>
                        <option value="<?php echo $movie['MovieID']; ?>" <?php echo ($movie['MovieID'] == $schedule['MovieID']) ? 'selected' : ''; ?>><?php echo $movie['MovieTitle']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="datetime-local" id="start_time" name="start_time" value="<?php echo date('Y-m-d\TH:i', strtotime($schedule['StartTime'])); ?>" class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="datetime-local" id="end_time" name="end_time" value="<?php echo date('Y-m-d\TH:i', strtotime($schedule['EndTime'])); ?>" class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($schedule['Duration']); ?>" placeholder="Duration (e.g., 2h 30m)" class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" value="<?php echo htmlspecialchars($schedule['amount']); ?>" class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label for="total_seat" class="block text-sm font-medium text-gray-700">Total Seats</label>
                <input type="number" id="total_seat" name="total_seat" value="<?php echo htmlspecialchars($schedule['total_seat']); ?>" class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700" required>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Update Schedule</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>