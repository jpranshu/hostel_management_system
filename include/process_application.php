<?php
// Include your database connection file
include './connect.php';


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $type = $_POST['type'];
    $description = $_POST['description'];
    $transactionId = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : null; // Check if transaction_id is set

    // Retrieve user details from the session
    $rollNumber = $_SESSION['user_id']; // Assuming 'user_id' contains roll number in the session

    // Retrieve room number and hostel_id based on the user_id
    $sql_get_room_hostel = "SELECT room_number, hostel_id FROM room WHERE student_1 = ? OR student_2 = ? OR student_3 = ?";
    $stmt_get_room_hostel = $conn->prepare($sql_get_room_hostel);
    $stmt_get_room_hostel->bind_param("sss", $rollNumber, $rollNumber, $rollNumber);
    $stmt_get_room_hostel->execute();
    $stmt_get_room_hostel->bind_result($roomNumber, $hostelId);

    // Fetch the result
    $stmt_get_room_hostel->fetch();

    // Close the statement
    $stmt_get_room_hostel->close();

    // Prepare and execute the SQL query to insert data into the application table
    $sql_insert_application = "INSERT INTO application (roll_number, type, hostel_id, transaction_id, description, status, room_number, remark)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_insert_application = $conn->prepare($sql_insert_application);

    if ($stmt_insert_application) {
        // Bind parameters
        $stmt_insert_application->bind_param("ssssssis", $rollNumber, $type, $hostelId, $transactionId, $description, $status, $roomNumber, $remark);

        // Set values for the parameters
        $status = "requested"; // Replace with the actual status
        $remark = " "; // Replace with the actual remark

        // Execute the prepared statement
        $stmt_insert_application->execute();

        // Check if the insertion was successful
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
?>
