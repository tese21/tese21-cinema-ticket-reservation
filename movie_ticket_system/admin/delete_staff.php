<?php
// Include database connection
include '../config/db.php';

// Check if staff ID is set in URL
if (isset($_GET['id'])) {
    $staffID = $_GET['id'];

    // Prepare delete statement
    $sql = "DELETE FROM staff WHERE StaffID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staffID);

    if ($stmt->execute()) {
        echo "<script>alert('Staff deleted successfully!'); window.location.href='manage_staff.php';</script>";
    } else {
        echo "<script>alert('Error deleting staff!'); window.location.href='manage_staff.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='manage_staff.php';</script>";
}
$conn->close();
?>
