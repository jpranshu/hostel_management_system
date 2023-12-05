<?php
include './connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $rollNumber = $_POST['roll_number'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM student WHERE roll_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rollNumber);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['roll_number'];
            $_SESSION['user_type'] = 'student';


            header('Location: .././student_dashboard.php');
        } else {

            echo "Invalid password. Please try again.";
        }
    } else {

        echo "Student with Roll Number $rollNumber does not exist.";
    }

    $stmt->close();
}
