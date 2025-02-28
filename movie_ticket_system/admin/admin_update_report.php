<?php
session_start();
include('../config/db.php');

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
    exit();
}

// Function to update report data
function updateReportData($conn) {
    // Example: Update report data logic
    // You can add more complex logic here if needed

    // Update total movies
    $sql1 = "SELECT COUNT(*) AS total_movies FROM movie";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    $total_movies = $row1['total_movies'];

    // Update total customers
    $sql2 = "SELECT COUNT(*) AS total_customers FROM user WHERE Role = 'Customer'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $total_customers = $row2['total_customers'];

    // Update total staff
    $sql3 = "SELECT COUNT(*) AS total_staff FROM user WHERE Role = 'Staff'";
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_assoc();
    $total_staff = $row3['total_staff'];

    // Update total tickets
    $sql4 = "SELECT COUNT(*) AS total_tickets FROM transactions";
    $result4 = $conn->query($sql4);
    $row4 = $result4->fetch_assoc();
    $total_tickets = $row4['total_tickets'];

    // Update total schedules
    $sql5 = "SELECT COUNT(*) AS total_schedules FROM movie_schedule";
    $result5 = $conn->query($sql5);
    $row5 = $result5->fetch_assoc();
    $total_schedules = $row5['total_schedules'];

    // Update total movie schedules
    $sql6 = "SELECT COUNT(*) AS total_movie_schedules FROM movie_schedule";
    $result6 = $conn->query($sql6);
    $row6 = $result6->fetch_assoc();
    $total_movie_schedules = $row6['total_movie_schedules'];

    // You can store these values in a session or database if needed
    $_SESSION['report_data'] = [
        'total_movies' => $total_movies,
        'total_customers' => $total_customers,
        'total_staff' => $total_staff,
        'total_tickets' => $total_tickets,
        'total_schedules' => $total_schedules,
        'total_movie_schedules' => $total_movie_schedules
    ];
}

// Call the function to update report data
updateReportData($conn);

// Redirect back to the admin dashboard
header('Location: admin_dashboard.php');
exit();
?>