<?php

include './connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type = $_POST['type'];
    $description = $_POST['description'];
    $transactionId = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : null;


    $rollNumber = $_SESSION['user_id'];

    $sql_get_room_hostel = "SELECT room_number, hostel_id FROM room WHERE student_1 = ? OR student_2 = ? OR student_3 = ?";
    $stmt_get_room_hostel = $conn->prepare($sql_get_room_hostel);
    $stmt_get_room_hostel->bind_param("sss", $rollNumber, $rollNumber, $rollNumber);
    $stmt_get_room_hostel->execute();
    $stmt_get_room_hostel->bind_result($roomNumber, $hostelId);


    $stmt_get_room_hostel->fetch();


    $stmt_get_room_hostel->close();

    $sql_insert_application = "INSERT INTO application (roll_number, type, hostel_id, transaction_id, description, status, room_number, remark)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_insert_application = $conn->prepare($sql_insert_application);

    if ($stmt_insert_application) {

        $stmt_insert_application->bind_param("ssssssis", $rollNumber, $type, $hostelId, $transactionId, $description, $status, $roomNumber, $remark);

        $status = "requested";
        $remark = " ";

        $stmt_insert_application->execute();

        if ($stmt_insert_application->affected_rows > 0) {
            echo "Application submitted successfully!";
        } else {
            echo "Error: Application submission failed.";
        }

        $stmt_insert_application->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
