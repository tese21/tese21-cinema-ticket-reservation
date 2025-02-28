<?php
include '../config/db.php'; // Ensure correct path

if (isset($_GET['id'])) {
    $seat_id = $_GET['id'];

    $query = "DELETE FROM available_seat WHERE SeatID = $seat_id";
    
    if (mysqli_query($conn, $query)) {
        echo "Seat deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
