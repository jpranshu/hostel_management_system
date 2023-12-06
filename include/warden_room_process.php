<?php
include './connect.php';

// Check if the user is logged in as a warden
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'warden') {
    // Redirect to the warden login page if not logged in as a warden
    header('Location: warden_login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];

    // Handle room reallotment approval
    if ($type === 'room_reallotment') {
        $applicationId = $_POST['application_id'];
        $status = $_POST['status'];
        $remarks = $_POST['remarks'];

        // Retrieve application details
        $sqlApplication = "SELECT * FROM application WHERE application_id = ?";
        $stmtApplication = $conn->prepare($sqlApplication);
        $stmtApplication->bind_param("i", $applicationId);
        $stmtApplication->execute();
        $resultApplication = $stmtApplication->get_result();

        if ($resultApplication->num_rows > 0) {
            $application = $resultApplication->fetch_assoc();

            // Check the current room capacity
            $sqlCapacityCheck = "SELECT student_1, student_2, student_3 FROM room
                                 WHERE room_number = ? AND hostel_id = ?";
            $stmtCapacityCheck = $conn->prepare($sqlCapacityCheck);
            $stmtCapacityCheck->bind_param("is", $application['transaction_id'], $application['hostel_id']);
            $stmtCapacityCheck->execute();
            $resultCapacityCheck = $stmtCapacityCheck->get_result();

            $sqlCapacityCheck2 = "SELECT student_1, student_2, student_3 FROM room
                                 WHERE room_number = ? AND hostel_id = ?";
            $stmtCapacityCheck2 = $conn->prepare($sqlCapacityCheck2);
            $stmtCapacityCheck2->bind_param("is", $application['room_number'], $application['hostel_id']);
            $stmtCapacityCheck2->execute();
            $resultCapacityCheck2 = $stmtCapacityCheck2->get_result();

            if ($resultCapacityCheck) {
                $roomData = $resultCapacityCheck->fetch_assoc();
                $roomData2 = $resultCapacityCheck2->fetch_assoc();

                $roomUpdate = NULL;
                if ($roomData2['student_1'] == $application['roll_number']) {
                    $roomUpdate = 'student_1';
                } else if ($roomData2['student_2'] == $application['roll_number']) {
                    $roomUpdate = 'student_2';
                } else if ($roomData2['student_3'] == $application['room_number']) {
                    $roomUpdate = 'student_3';
                }

                if ($roomData['student_1'] !== NULL && $roomData['student_2'] !== NULL && $roomData['student_3'] !== NULL) {
                    echo "Room is at maximum capacity. Please choose another room.";
                } else {
                    // Find the first available student column
                    $availableColumn = null;
                    if ($roomData['student_1'] === NULL) {
                        $availableColumn = 'student_1';
                    } elseif ($roomData['student_2'] === NULL) {
                        $availableColumn = 'student_2';
                    } elseif ($roomData['student_3'] === NULL) {
                        $availableColumn = 'student_3';
                    }


                    if ($availableColumn) {
                        // Remove the record of the student from their current room
                        $sqlRemoveStudentFromRoom = "UPDATE room SET $roomUpdate = NULL 
                                                     WHERE room_number = ? AND hostel_id = ?";
                        $stmtRemoveStudentFromRoom = $conn->prepare($sqlRemoveStudentFromRoom);
                        $stmtRemoveStudentFromRoom->bind_param("is", $application['room_number'], $application['hostel_id']);
                        $stmtRemoveStudentFromRoom->execute();

                        // Update the room with the new student
                        $sqlUpdateRoom = "UPDATE room SET $availableColumn = ? 
                                          WHERE room_number = ? AND hostel_id = ?";
                        $stmtUpdateRoom = $conn->prepare($sqlUpdateRoom);
                        $stmtUpdateRoom->bind_param("sis", $application['roll_number'], $application['transaction_id'], $application['hostel_id']);
                        $stmtUpdateRoom->execute();

                        // Update the student's room number
                        $sqlUpdateStudent = "UPDATE student SET room_number = ? 
                                             WHERE roll_number = ?";
                        $stmtUpdateStudent = $conn->prepare($sqlUpdateStudent);
                        $stmtUpdateStudent->bind_param("ss", $application['transaction_id'], $application['roll_number']);
                        $stmtUpdateStudent->execute();

                        // Update the application status and remarks
                        $sqlUpdateApplication = "UPDATE application SET status = ?, remark = ? 
                                                WHERE application_id = ?";
                        $stmtUpdateApplication = $conn->prepare($sqlUpdateApplication);
                        $stmtUpdateApplication->bind_param("ssi", $status, $remarks, $applicationId);
                        $stmtUpdateApplication->execute();

                        // Redirect or display success message as needed
                        header('Location: ../warden_dashboard.php');
                        exit();
                    } else {
                        echo "Error: No available column in the room table.";
                    }
                }
            } else {
                echo "Error: Room capacity check failed.";
            }
        } else {
            // Application not found
            echo "Error: Application not found.";
        }
    }
}
