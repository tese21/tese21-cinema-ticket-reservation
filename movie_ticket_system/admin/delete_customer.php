<?php
// Include database connection
include '../config/db.php';

// Check if UserID is set in the URL
if (isset($_GET['UserID'])) {
    $customer_id = $_GET['UserID'];

    // Prepare delete statement
    $sql = "DELETE FROM user WHERE UserID = ? AND Role = 'Customer'";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
        echo "<script>alert('Customer deleted successfully!'); window.location.href='customer_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting customer!'); window.location.href='customer_list.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='customer_list.php';</script>";
}
$conn->close();
?>
