<?php
// Include database connection
include 'config/db.php';

// Start session to get the logged-in user's ID
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us - Movie Ticket System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <?php include('header.php'); ?>

    <!-- About Us Section -->
    <section id="about-us" class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">About Us</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
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
    <?php include('footer.php'); ?>
</body>
</html>