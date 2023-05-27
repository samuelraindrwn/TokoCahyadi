<?php
// Start session
session_start();

// Unset all session data
session_unset();

// Destroy session
session_destroy();

// Redirect to login page
header("Location: loginPage.php");
exit;
?>