<?php
// Include your database connection file
include './connect.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $warden_id = $_POST['warden_id'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query to retrieve warden details
    $sql = "SELECT * FROM warden WHERE warden_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $warden_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the warden exists and the password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Warden authentication successful
            $_SESSION['user_id'] = $row['warden_id'];
            $_SESSION['user_type'] = 'warden';
            $_SESSION['hostel_id'] = $row['hostel_id'];

            // Redirect to the warden dashboard or any desired page
            header('Location: warden_dashboard.php');
            exit();
        } else {
            // Password is incorrect
            $_SESSION['login_error'] = "Invalid password. Please try again.";
        }
    } else {
        // Warden does not exist
        $_SESSION['login_error'] = "Warden with ID $warden_id does not exist.";
    }

    $stmt->close();
    // Close the database connection

    // Redirect back to the login form
    header('Location: ../warden_login.php');
    exit();
}
?>
