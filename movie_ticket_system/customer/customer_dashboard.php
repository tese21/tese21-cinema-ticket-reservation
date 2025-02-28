<?php
// Include database connection
include '../config/db.php';

// Start session to get the logged-in user's ID
session_start();
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if UserID is not set in session
    header("Location: ../login.php");
    exit();
}

$userID = $_SESSION['UserID'];

// Fetch user details from the database
$sql = "SELECT Fname, Lname, Phone FROM user WHERE UserID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$fullName = $user['Fname'] . ' ' . $user['Lname'];
$phone = $user['Phone'];

// Fetch all movies to display movie titles and images
$sql = "SELECT MovieID, MovieTitle, ProfileImage FROM movie";
$result = $conn->query($sql);
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Online Movie Ticket Reservation System</title>
  <!-- Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // AJAX request to fetch movie data for the marquee
      function loadMovies() {
        $.ajax({
          url: '../fetch_movies.php', // Path to the PHP file that fetches the movies
          method: 'GET',
          success: function(response) {
            $('.marquee-content').html(response); // Insert the fetched data into the marquee content
          }
        });
      }
      // Call the function to load the movies when the page is ready
      loadMovies();
    });

    function bookNow(movieID) {
      const userID = "<?php echo $userID; ?>";
      const phone = "<?php echo $phone; ?>";
      const fullName = "<?php echo $fullName; ?>";
      const url = `../booking/checkout.php?user_id=${encodeURIComponent(userID)}&movie_id=${encodeURIComponent(movieID)}&phone=${encodeURIComponent(phone)}&full_name=${encodeURIComponent(fullName)}`;
      window.location.href = url;
    }
  </script>
  <style>
    body {
      background-image: url('../img/bacc.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
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
    @keyframes scroll {
      0% {
        transform: translateX(100%);
      }
      100% {
        transform: translateX(-100%);
      }
    }
    .animate-scroll {
      animation: scroll 20s linear infinite;
    }
    .hover-effect:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transition: background-color 0.3s ease;
    }
    .dropdown-content {
      display: none;
    }
    .dropdown-content.show {
      display: block;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
  <!-- Header -->
  <?php include ('header.php');?>
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
                            <img src="../uploads/<?php echo htmlspecialchars($movie['ProfileImage']); ?>" alt="<?php echo htmlspecialchars($movie['MovieTitle']); ?>" class="w-40 h-60 object-cover rounded-lg border-2 border-yellow-400 shadow-md">
                            <p class="text-xs mt-1"> <?php echo htmlspecialchars($movie['MovieTitle']); ?> </p>
                        </div>
                    <?php endwhile;
                else:
                    echo "<p class='text-white text-center'>No movies available</p>";
                endif;
                ?>
            </marquee>
    </div>

    <h2 class="text-3xl font-bold text-center mt-8 mb-6 text-yellow-400 animate-pulse">Welcome to our Cinema ticket reservation system</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php
      $sql = "SELECT MovieID, MovieTitle, ProfileImage FROM movie";
      $result = $conn->query($sql);
      if ($result->num_rows > 0):
        while ($movie = $result->fetch_assoc()): ?>
          <div class="bg-gray-800 p-4 rounded-lg text-center shadow-lg transform transition duration-500 hover:scale-105">
            <img src="../uploads/<?php echo $movie['ProfileImage']; ?>" alt="<?php echo $movie['MovieTitle']; ?>" class="w-full h-80 object-cover rounded">
            <h3 class="mt-4 text-lg font-semibold"> <?php echo $movie['MovieTitle']; ?> </h3>
            <button onclick="bookNow('<?php echo $movie['MovieID']; ?>')" class="block mt-2 bg-yellow-500 text-black py-2 px-4 rounded hover:bg-yellow-600 transition duration-300">Book Now</button>
          </div>
        <?php endwhile;
      else:
        echo "<p class='text-center'>No movies available at the moment.</p>";
      endif;
      ?>
    </div>
  </section>

  <!-- Next Button -->
  <button class="next absolute right-0 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-200 transition duration-300">
    <i class="fas fa-chevron-right"></i>
  </button>

  <!-- About Section -->
  <section id="about" class="my-12 px-4">
    <div class="container mx-auto">
      <h2 class="text-2xl font-bold mb-4">About Us</h2>
      <p class="text-gray-700">
        Welcome to our movie ticket reservation platform, where you can seamlessly browse and book your favorite movies. 
        Whether you're a customer, staff member, or administrator, we provide an intuitive interface to cater to your needs.
      </p>
    </div>
  </section>
  <!-- Features Section -->
  <section id="features" class="my-12 px-4">
    <div class="container mx-auto">
      <h2 class="text-2xl font-bold mb-6">Key Features</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Feature: Browse Movies -->
        <div class="feature bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <div class="feature-icon text-blue-500 text-4xl mb-2">
            <i class="fas fa-film"></i>
          </div>
          <a href="search_movie.php" class="hover:underline">
            <h3 class="text-xl font-semibold">Browse Movies</h3>
          </a>
          <p class="text-gray-600 mt-1">Find movies by genre, title, or schedule.</p>
        </div>
        <!-- Feature: Book Tickets -->
        <div class="feature bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <div class="feature-icon text-green-500 text-4xl mb-2">
            <i class="fas fa-ticket-alt"></i>
          </div>
          <h3 class="text-xl font-semibold">Book Tickets</h3>
          <p class="text-gray-600 mt-1">Secure your seats for the latest movies.</p>
        </div>
       
        <div class="feature bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <div class="feature-icon text-purple-500 text-4xl mb-2">
            <i class="fas fa-cogs"></i>
          </div>
          <a href="developers.php" class="hover:underline">
          <h3 class="text-xl font-semibold">Developer</h3>
          <p class="text-gray-600 mt-1">Developers </p>
        </div>
     
        <div class="feature bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
          <div class="feature-icon text-red-500 text-4xl mb-2">
            <i class="fas fa-user-shield"></i>
          </div>
          <a href="../contact_us.php" class="hover:underline">
            <h3 class="text-xl font-semibold">Contact</h3>
          </a>
          <p class="text-gray-600 mt-1">Give feedback or ask any questions.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include ('../footer.php');?>

  
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>