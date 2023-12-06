<?php
include './connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'warden') {
    header('Location: warden_login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomNumber = $_POST['room_number'];

    $wardenHostelId = $_SESSION['hostel_id'];

    $capacity = $_POST['capacity'];


    $sqlInsertRoom = "INSERT INTO room (room_number, hostel_id, capacity) VALUES (?, ?, ?)";
    $stmtInsertRoom = $conn->prepare($sqlInsertRoom);
    $stmtInsertRoom->bind_param("ssi", $roomNumber, $wardenHostelId, $capacity);

    if ($stmtInsertRoom->execute()) {
        header('Location: ../warden_dashboard.php?message=Room%20Added');
    } else {
        echo "Error: " . $stmtInsertRoom->error;
    }

    $stmtInsertRoom->close();
}
?>
