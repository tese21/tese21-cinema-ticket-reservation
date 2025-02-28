<?php
// Start the session
session_start();

// Destroy all session data to log out the user
session_unset();
session_destroy();

// Redirect to the login page or admin login page
header("Location:../login.php");  // Replace with actual login page URL
exit();
?>/
