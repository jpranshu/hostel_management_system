<?php
include 'include/connect.php';

// Unset specific session variables
unset($_SESSION['user_id']);
unset($_SESSION['user_type']);
unset($_SESSION['hostel_id']);

// Destroy the session
session_destroy();

// Redirect to the index page
header('Location: index.php');
exit();
?>
