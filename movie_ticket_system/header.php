<?php
// Include database connection
include 'config/db.php';

$movies = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_movie'])) {
    $title = $_POST['title'];

    // Use a prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM movie WHERE MovieTitle LIKE ? OR Director LIKE ? OR Cast LIKE ?");
    $searchTerm = '%' . $title . '%';
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm); // "sss" indicates three strings

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $movies = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Ticket System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <style>
        nav {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <!-- Header Section -->
    <header class="bg-blue-600 p-4 shadow-md flex justify-between items-center">
        <!-- Navbar -->
        <nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 shadow-lg">
            <div class="container mx-auto flex justify-between items-center py-4 px-6">
                <div class="logo-container">
                    <img src="img/log.png" alt="Logo" class="h-12" />
                </div>
                
                <!-- Search Bar -->
                <form action="search_movie.php" method="GET" class="relative flex items-center">
                    <input type="text" id="searchInput" name="query" placeholder="Search movies..." class="p-2 pl-4 pr-10 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <button type="submit" class="absolute right-2 top-2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 2a6 6 0 100 12A6 6 0 008 2zm10 14a1 1 0 01-1.414 0l-3.829-3.828a8 8 0 111.415-1.414l3.828 3.829a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </form>

                <ul class="flex space-x-4">
                    <li><a class="text-white hover:text-yellow-400" href="#movies">Home</a></li>
                    <li><a class="text-white hover:text-yellow-400" href="#movies">Movies</a></li>
                    <li><a class="text-white hover:text-yellow-400" href="#about-us">About Us</a></li>
                    <li><a class="text-white hover:text-yellow-400" href="schedule.php">Schedule</a></li>
                    <li><a class="text-white hover:text-yellow-400" href="login.php">Login</a></li>
                    <li><a class="text-white hover:text-yellow-400" href="customer/register.php">Register</a></li>
                    <li><a class="text-white hover:text-yellow-400" href="help.php">Help</a></li>
                    <li><a class="text-white hover:text-yellow-400" href="contact_us.php">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>
</body>
</html>