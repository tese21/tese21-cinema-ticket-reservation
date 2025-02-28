<?php include 'config/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-image: url('img/bacc.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: rgba(31, 41, 55, 0.8);
        }
        .navbar.scrolled {
            background-color: rgba(31, 41, 55, 1);
        }
        .movie-card:hover .movie-image {
            transform: scale(1.05);
        }
        .movie-card:hover .book-now-btn {
            background-color: #d97706;
        }
    </style>
</head>
<body class="font-sans">
    
<?php include('header.php'); ?>
    <!-- Movie Display Section -->
    <section id="movies" class="container mx-auto py-10 px-3">
        <div class="bg-gray-800 py-2 overflow-hidden">
            <marquee behavior="scroll" direction="left" scrollamount="5" class="flex space-x-6">
                <?php
                $sql = "SELECT MovieTitle, ProfileImage FROM movie";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                    while ($movie = $result->fetch_assoc()): ?>
                        <div class="inline-block text-center">
                            <img src="uploads/<?php echo htmlspecialchars($movie['ProfileImage']); ?>" alt="<?php echo htmlspecialchars($movie['MovieTitle']); ?>" class="w-40 h-60 object-cover rounded-lg border-2 border-yellow-400 shadow-md">
                            <p class="text-xs mt-1"> <?php echo htmlspecialchars($movie['MovieTitle']); ?> </p>
                        </div>
                    <?php endwhile;
                else:
                    echo "<p class='text-white text-center'>No movies available</p>";
                endif;
                ?>
            </marquee>
        </div>

        <h2 class="text-3xl font-bold text-center mt-8 mb-6 text-yellow-400">Welcome to our Cinema ticket reservation system</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            $sql = "SELECT MovieTitle, ProfileImage FROM movie";
            $result = $conn->query($sql);
            if ($result->num_rows > 0):
                while ($movie = $result->fetch_assoc()): ?>
                    <div class="movie-card bg-gray-800 p-4 rounded-lg text-center shadow-lg transition-transform duration-300">
                        <img src="uploads/<?php echo htmlspecialchars($movie['ProfileImage']); ?>" alt="<?php echo htmlspecialchars($movie['MovieTitle']); ?>" class="movie-image w-full h-80 object-cover rounded transition-transform duration-300">
                        <h3 class="mt-4 text-lg font-semibold"> <?php echo htmlspecialchars($movie['MovieTitle']); ?> </h3>
                        <a href="#" onclick="checkLogin(event, '<?php echo addslashes($movie['MovieTitle']); ?>')" class="book-now-btn block mt-2 bg-yellow-500 text-black py-2 px-4 rounded hover:bg-yellow-600 transition duration-300">Book Now</a>
                    </div>
                <?php endwhile;
            else:
                echo "<p class='text-center'>No movies available at the moment.</p>";
            endif;
            ?>
        </div>
    </section>
    <section id="about-us" class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">About Us</h2>
        <div class=" p-6 rounded-lg shadow-md">
            <p class="text-lg mb-4">
                Welcome to our Movie Ticket Reservation System! We are dedicated to providing you with the best movie-going experience. Our platform allows you to easily browse and book tickets for your favorite movies from the comfort of your home.
            </p>
            <p class="text-lg mb-4">
                Our mission is to make movie ticket booking as convenient and hassle-free as possible. With our user-friendly interface, you can quickly find the latest movies, check showtimes, and reserve your seats in just a few clicks.
            </p>
            <p class="text-lg mb-4">
                We offer a wide range of movies, from the latest blockbusters to classic films. Our system is designed to provide you with detailed information about each movie, including the cast, director, genre, and a brief synopsis.
            </p>
            <p class="text-lg mb-4">
                Thank you for choosing our Movie Ticket Reservation System. We hope you enjoy your movie experience with us!
            </p>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-gray-800 py-4 text-center mt-10">
        <?php include ('footer.php'); ?>
    </footer>

    <script>
        $(document).ready(function () {
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 50) {
                    $('#navbar').addClass('scrolled');
                } else {
                    $('#navbar').removeClass('scrolled');
                }
            });
        });

       

        function checkLogin(event, movieTitle) {
            event.preventDefault();
            // Add your login check logic here
            alert("Login check for movie: " + movieTitle);
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
