<?php
include 'config/db.php'; // Include the database connection

// Get current date and time
$currentDateTime = date('Y-m-d H:i:s');

// Calculate the date and time for 24 hours later
$endDateTime = date('Y-m-d H:i:s', strtotime('+24 hours'));

// Fetch movies with ScheduleID within the next 24 hours
$sql = "SELECT * FROM todaymovie
        WHERE DisplayDate BETWEEN '$currentDateTime' AND '$endDateTime' AND IsShowing = TRUE";

$result = $conn->query($sql);

// Check if there are any movies scheduled within the next 24 hours
if ($result->num_rows > 0):
?>
<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>የቀረበ ፊልሞች</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-image: url('http://demos.creative-tim.com/paper-kit-2/assets/img/antoine-barres.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-transparent transition-all duration-500" id="navbar">
        <div class="container mx-auto flex justify-between items-center py-4">
            <div class="logo-container">
                <img src="img/log.png" alt="አርማ" class="h-12">
            </div>
            <ul class="flex space-x-4">
                <li><a class="nav-link" href="#movies">ፊልሞች</a></li>
                <li><a class="nav-link" href="booking/book.php">ትኬቶች</a></li>
                <li><a class="nav-link" href="schedule.php">የጊዜ ሰሌዳ</a></li>
                <li><a href="#about" class="nav-link">ስለ እኛ</a></li>
                <li><a class="nav-link" href="login.php">ግባ</a></li>
                <li><a class="nav-link" href="customer/register.php">ይመዝገቡ</a></li>
                <li><a href="help.php" class="nav-link">እርዳታ</a></li>
                <li><a href="contact_us.php" class="nav-link">አግኙን</a></li>
            </ul>
        </div>
    </nav>

    <!-- Movie Display Section -->
    <section id="movies" class="container mx-auto py-10">
        <h2 class="text-2xl font-bold text-center mb-6">የቀረበ ፊልሞች</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while ($movie = $result->fetch_assoc()): ?>
                <div class="bg-gray-800 p-4 rounded-lg text-center">
                    <img src="uploads/<?php echo $movie['ProfileImage']; ?>" alt="<?php echo $movie['MovieTitle']; ?>" class="w-full h-60 object-cover rounded">
                    <h3 class="mt-4 text-lg font-semibold"><?php echo $movie['MovieTitle']; ?></h3>
                    <p class="text-sm mt-2"><?php echo $movie['MovieDescription']; ?></p>
                    <a href="#" class="block mt-2 bg-yellow-500 text-black py-2 rounded">አሁን ይያዙ</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <footer>
        <?php include ('footer.php'); ?>
    </footer>

    <script>
        $(document).ready(function () {
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 50) {
                    $('#navbar').removeClass('bg-transparent').addClass('bg-white shadow-md');
                } else {
                    $('#navbar').addClass('bg-transparent').removeClass('bg-white shadow-md');
                }
            });
        });
    </script>

</body>
</html>

<?php
else:
    echo "<p class='text-white text-center'>በቀረበ 24 ሰዓታት ስለ ምንም ፊልም የለም።</p>";
endif;

$conn->close();
?>
