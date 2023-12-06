<?php
include './connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'warden') {
    // Redirect to the warden login page if not logged in as a warden
    header('Location: warden_login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomNumber = $_POST['room_number'];
    
    // Retrieve the hostel_id from the session variable
    $wardenHostelId = $_SESSION['hostel_id'];

    // Other form inputs
    $capacity = $_POST['capacity'];

    // Perform validation if needed

    // Insert room into the database
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
