<?php
include './connect.php';


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $rollNumber = $_SESSION['user_id']; // Assuming the user is already logged in
    $type = $_POST['type'];
    $hostelId = $_POST['hostel_id'];
    $transactionId = $_POST['new_room'];
    $description = $_POST['description'];
    $status = 'requested'; // Initial status for a new application
    $roomNumber = $_POST['room_number'];; // Room number will be updated after verification
    $remark = ''; // Initial remark

    // Prepare and execute the SQL query to insert the new application
    $sql = "INSERT INTO application (roll_number, type, hostel_id, transaction_id, description, status, room_number, remark)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissis", $rollNumber, $type, $hostelId, $transactionId, $description, $status, $roomNumber, $remark);
    $stmt->execute();
    $stmt->close();

    // Redirect or display success message as needed
    header('Location: success_page.php');
    exit();
}
?>
