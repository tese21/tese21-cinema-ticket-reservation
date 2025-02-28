<?php
// Include database connection
include '../config/db.php';

// Handle form submission for searching movie schedules
$schedules = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_schedule'])) {
    $movieID = $_POST['movie_id'];
    $sql = "SELECT * FROM movie_schedule WHERE MovieID = '$movieID'";
    $result = $conn->query($sql);
    $schedules = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Movie Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background-image: url('../img/bacc.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: white;
        }
        .schedule-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .schedule-card {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
            transition: transform 0.3s ease-in-out;
        }
        .schedule-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <header class="text-center my-8">
        <h1 class="text-4xl font-bold animate__animated animate__fadeInDown">Search Movie Schedule</h1>
        <a href="../index.php" class="text-blue-500 hover:underline">Back to Home</a>
    </header>
    <main class="container mx-auto p-8">
        <form method="POST" action="search_schedule.php" class="mb-8">
            <div class="flex items-center justify-center">
                <label for="movie_id" class="mr-4 text-lg">Select Movie:</label>
                <select name="movie_id" id="movie_id" class="p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    <?php
                    // Fetch movie list for dropdown
                    $movie_query = "SELECT * FROM movie";
                    $movie_result = $conn->query($movie_query);
                    while ($movie = $movie_result->fetch_assoc()) {
                        echo "<option value='" . $movie['MovieID'] . "'>" . $movie['MovieTitle'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="search_schedule" class="ml-4 py-2 px-4 bg-yellow-500 text-black font-semibold rounded hover:bg-yellow-600 transition duration-300">Search Schedule</button>
            </div>
        </form>

        <?php if (count($schedules) > 0): ?>
            <h2 class="text-2xl font-bold mb-4">Available Schedules:</h2>
            <div class="schedule-container">
                <?php foreach ($schedules as $schedule): ?>
                    <div class="schedule-card animate__animated animate__fadeInUp">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($schedule['GenerateDay']); ?></h3>
                        <p class="mt-2"><?php echo htmlspecialchars($schedule['Scheduled']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (isset($_POST['search_schedule'])): ?>
            <p class="text-center text-xl">No schedule available for this movie.</p>
        <?php endif; ?>
    </main>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
