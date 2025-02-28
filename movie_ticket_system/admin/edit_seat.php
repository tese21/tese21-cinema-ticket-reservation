<?php
include '../config/db.php'; // Ensure correct path to database connection

if (isset($_GET['id'])) {
    $seat_id = $_GET['id'];

    $query = "SELECT * FROM available_seat WHERE SeatID = $seat_id";
    $result = mysqli_query($conn, $query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        die("Seat not found.");
    }

    $seat = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seat_no = $_POST['seat_no'];
    $seat_level = $_POST['seat_level'];
    $schedule_id = $_POST['schedule_id'];

    $update_query = "UPDATE available_seat SET SeatNo='$seat_no', SeatLevel='$seat_level', ScheduleID='$schedule_id' WHERE SeatID=$seat_id";
    
    if (mysqli_query($conn, $update_query)) {
        echo "Seat updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Seat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Seat</h2>
    <form action="" method="post">
        <label for="seat_no">Seat No:</label>
        <input type="text" name="seat_no" value="<?= $seat['SeatNo']; ?>" required><br>

        <label for="seat_level">Seat Level:</label>
        <select name="seat_level" required>
            <option value="Standard" <?= ($seat['SeatLevel'] == 'Standard') ? 'selected' : ''; ?>>Standard</option>
            <option value="Premium" <?= ($seat['SeatLevel'] == 'Premium') ? 'selected' : ''; ?>>Premium</option>
            <option value="VIP" <?= ($seat['SeatLevel'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
        </select><br>

        <label for="schedule_id">Schedule ID:</label>
        <input type="number" name="schedule_id" value="<?= $seat['ScheduleID']; ?>" required><br>

        <button type="submit">Update Seat</button>
    </form>
</body>
</html>
