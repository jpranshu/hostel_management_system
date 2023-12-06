<?php
include './connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $rollNumber = $_SESSION['user_id']; 
    $type = $_POST['type'];
    $hostelId = $_POST['hostel_id'];
    $transactionId = $_POST['new_room'];
    $description = $_POST['description'];
    $status = 'requested'; 
    $roomNumber = $_POST['room_number'];; 
    $remark = ''; 

    $sql = "INSERT INTO application (roll_number, type, hostel_id, transaction_id, description, status, room_number, remark)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissis", $rollNumber, $type, $hostelId, $transactionId, $description, $status, $roomNumber, $remark);
    $stmt->execute();
    $stmt->close();

    header('Location: ../student_dashboard.php?message=Application%20Processed');
    exit();
}
?>
