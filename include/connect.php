<?php
session_start();

DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'hostel_management');

$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Unable to connect to My SQL Server !' .
        mysqli_connect_error());
$_SESSION["sql_connect"] = $conn;
