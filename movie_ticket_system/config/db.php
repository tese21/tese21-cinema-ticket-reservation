<?php
// Database configuration
$host = "localhost"; // Hostname (usually "localhost")
$user = "root";      // Database username
$password = "";      // Database password (leave blank for default setups like XAMPP)
$database = "cinema_ticket_reservation"; // Database name

// Create a connection
$conn = new mysqli($host, $user, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment the line below to display a successful connection message during testing
// echo "Connected successfully";
?>
