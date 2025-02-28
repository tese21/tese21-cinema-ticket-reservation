<?php
include('../config/db.php');

session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header('location:../login.php');
    exit();
}

$userID = $_SESSION['UserID'];
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movieID = $_POST['movie_id'] ?? '';
   
    $rating = $_POST['rating'] ?? '';
    $feedbackDescription = $_POST['feedback_description'] ?? '';

    // Validate input
    if (empty($movieID)  || empty($rating) || empty($feedbackDescription)) {
        $error_message = "All fields are required.";
    } else {
        // Insert feedback into the database
        $stmt = $conn->prepare("INSERT INTO feedback (MovieID, SeatID, Rating, FeedbackDescription, UserID) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            $error_message = "Error preparing the statement: " . $conn->error;
        } else {
            $stmt->bind_param("iiisi", $movieID, $seatID, $rating, $feedbackDescription, $userID);
            if ($stmt->execute()) {
                $success_message = "Feedback submitted successfully!";
            } else {
                $error_message = "Error submitting feedback: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Fetch movies for the dropdown
$movies_query = "SELECT MovieID, MovieTitle FROM movie";
$movies_result = mysqli_query($conn, $movies_query);

// Fetch seats for the dropdown
$seats_query = "SELECT SeatID, seatNo FROM available_seat";
$seats_result = mysqli_query($conn, $seats_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6">Submit Feedback</h2>
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
        <form action="feedback.php" method="POST">
            <div class="mb-4">
                <label for="movie_id" class="block text-sm font-medium text-gray-700">Movie</label>
                <select id="movie_id" name="movie_id" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
                    <option value="">Select Movie</option>
                    <?php while ($movie = mysqli_fetch_assoc($movies_result)): ?>
                        <option value="<?php echo $movie['MovieID']; ?>"><?php echo $movie['MovieTitle']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <select id="rating" name="rating" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
                    <option value="">Select Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="5">6</option>
                    <option value="5">7</option>
                    <option value="5">8</option>
                    <option value="5">9</option>
                    <option value="5">10</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="feedback_description" class="block text-sm font-medium text-gray-700">Feedback Description</label>
                <textarea id="feedback_description" name="feedback_description" rows="4" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700"></textarea>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Submit Feedback</button>
        </form>
    </div>
</body>
</html>