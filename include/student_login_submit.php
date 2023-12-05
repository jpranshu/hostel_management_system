<?php
// Include your database connection file
include './connect.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $rollNumber = $_POST['roll_number'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query to retrieve student details
    $sql = "SELECT * FROM student WHERE roll_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rollNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the student exists and the password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Student authentication successful
            $_SESSION['user_id'] = $row['roll_number'];
            $_SESSION['user_type'] = 'student';

            // Redirect to the student dashboard
            header('Location: .././student_dashboard.php');
        } else {
            // Password is incorrect
            echo "Invalid password. Please try again.";
        }
    } else {
        // Student does not exist
        echo "Student with Roll Number $rollNumber does not exist.";
    }

    $stmt->close();
    // Close the database connection

}
?>
