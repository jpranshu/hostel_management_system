<?php
// Include your database connection file
include './connect.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $rollNumber = $_POST['roll_number'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $contactNumber = $_POST['contact_number'];
    $email = $_POST['email'];
    $hostelId = $_POST['hostel_id'];
    $roomNumber = $_POST['room_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if the room exists for the specified hostel_id
    $sql_check_room_existence = "SELECT * FROM room WHERE room_number = '$roomNumber' AND hostel_id = '$hostelId'";
    $result_check_room_existence = mysqli_query($conn, $sql_check_room_existence);

    if (!$result_check_room_existence || mysqli_num_rows($result_check_room_existence) === 0) {
        // Room does not exist, so insert a new room
        $sql_insert_room = "INSERT INTO room (room_number, hostel_id) VALUES ('$roomNumber', '$hostelId')";
        mysqli_query($conn, $sql_insert_room);
    }

    // Check if the selected room is at maximum capacity
    $sql_capacity_check = "SELECT student_1, student_2, student_3 FROM room
                           WHERE room_number = '$roomNumber' AND hostel_id = '$hostelId'";

    $result_capacity_check = mysqli_query($conn, $sql_capacity_check);

    if ($result_capacity_check) {
        $roomData = mysqli_fetch_assoc($result_capacity_check);

        // Check if the room is at maximum capacity
        if ($roomData['student_1'] !== NULL && $roomData['student_2'] !== NULL && $roomData['student_3'] !== NULL) {
            echo "Room is at maximum capacity. Please choose another room.";
        } else {
            // Find the first available section and update the room
            if ($roomData['student_1'] === NULL) {
                $sql_update_room = "UPDATE room SET student_1 = '$rollNumber'
                    WHERE room_number = '$roomNumber' AND hostel_id = '$hostelId'";
            } else if ($roomData['student_2'] === NULL) {
                $sql_update_room = "UPDATE room SET student_2 = '$rollNumber'
                    WHERE room_number = '$roomNumber' AND hostel_id = '$hostelId'";
            } else if ($roomData['student_3'] === NULL) {
                $sql_update_room = "UPDATE room SET student_3 = '$rollNumber'
                    WHERE room_number = '$roomNumber' AND hostel_id = '$hostelId'";
            }

            // Insert data into the "student" table
            $sql_insert_student = "INSERT INTO student (roll_number, name, gender, contact_number, email, hostel_id, room_number, password)
                VALUES ('$rollNumber', '$name', '$gender', $contactNumber, '$email', '$hostelId', '$roomNumber', '$password')";

            if (mysqli_query($conn, $sql_insert_student)) {
                echo "Student registration successful!";

                // Set session variables for student
                $_SESSION['user_id'] = $rollNumber;
                $_SESSION['user_type'] = 'student';

                // Redirect to a student dashboard or wherever you need
                header('Location: student_dashboard.php');

                
                mysqli_query($conn, $sql_update_room);
            } else {
                echo "Error: " . $sql_insert_student . "<br>" . mysqli_error($conn);
            }
        }
    } else {
        echo "Error checking room capacity: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
