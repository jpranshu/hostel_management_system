<?php
include 'include/connect.php';


unset($_SESSION['user_id']);
unset($_SESSION['user_type']);
unset($_SESSION['hostel_id']);


session_destroy();


header('Location: index.php');
exit();
