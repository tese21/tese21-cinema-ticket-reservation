<?php
// Include database connection
include '../config/db.php';

// Start session to get the logged-in user's ID
session_start();

// Fetch movie schedules from the database
$sql = "SELECT m.MovieTitle, m.ProfileImage, ms.ScheduleID, ms.StartTime, ms.EndTime, ms.Duration, ms.amount 
        FROM movie_schedule ms 
        JOIN movie m ON ms.MovieID = m.MovieID";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <?php include ('header.php');?>

    <!-- Movie Schedule Section -->
    <section id="schedule" class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">Movie Schedule</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0):
                while ($schedule = $result->fetch_assoc()): ?>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <img src="../uploads/<?php echo $schedule['ProfileImage']; ?>" alt="<?php echo $schedule['MovieTitle']; ?>" class="w-full h-60 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-bold mb-2"><?php echo $schedule['MovieTitle']; ?></h3>
                        <p class="text-gray-700"><strong>Schedule Date:</strong> <?php echo date('Y-m-d', strtotime($schedule['StartTime'])); ?></p>
                        <p class="text-gray-700"><strong>Start Time:</strong> <?php echo date('H:i', strtotime($schedule['StartTime'])); ?></p>
                        <p class="text-gray-700"><strong>End Time:</strong> <?php echo date('H:i', strtotime($schedule['EndTime'])); ?></p>
                        <p class="text-gray-700"><strong>Duration:</strong> <?php echo $schedule['Duration']; ?></p>
                        <p class="text-gray-700"><strong>Amount:</strong> <?php echo $schedule['amount']; ?></p>
                        <button onclick="bookNow('<?php echo $schedule['ScheduleID']; ?>')" class="block mt-4 bg-yellow-500 text-black py-2 px-4 rounded hover:bg-yellow-600 transition duration-300 text-center">Book Now</button>
                    </div>
                <?php endwhile;
            else:
                echo "<p class='text-center text-gray-700'>No movie schedules available</p>";
            endif;
            ?>
        </div>
    </section>

    <script>
        function bookNow(scheduleID) {
            const url = `../booking/checkout.php?schedule_id=${encodeURIComponent(scheduleID)}`;
            window.location.href = url;
        }
    </script>
</body>
</html>