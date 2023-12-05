<?php
// Include your database connection file
include './connect.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $warden_id = $_POST['warden_id'];
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $hostel_id = $_POST['hostel_id'];

    // Prepare and execute the SQL query to insert data into warden table
    $sql_insert_warden = "INSERT INTO warden (warden_id, name, contact_number, email, password, hostel_id) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt_insert_warden = $conn->prepare($sql_insert_warden);

    if ($stmt_insert_warden) {
        $stmt_insert_warden->bind_param("ssisss", $warden_id, $name, $contact_number, $email, $password, $hostel_id);
        $stmt_insert_warden->execute();

        // Check if the insertion into warden table was successful
        if ($stmt_insert_warden->affected_rows > 0) {
            // Now, update the hostel table with the warden_id
            $sql_update_hostel = "UPDATE hostel SET warden_id = ? WHERE hostel_id = ?";
            
            $stmt_update_hostel = $conn->prepare($sql_update_hostel);

            if ($stmt_update_hostel) {
                $stmt_update_hostel->bind_param("ss", $warden_id, $hostel_id);
                $stmt_update_hostel->execute();

                // Check if the update was successful
                if ($stmt_update_hostel->affected_rows > 0) {
                    echo "Warden registered successfully and hostel updated!";

                    // Set session variables for warden
                    $_SESSION['user_id'] = $warden_id;
                    $_SESSION['user_type'] = 'warden';

                    // Redirect to a warden dashboard or wherever you need
                   // header('Location: warden_dashboard.php');
                    exit();
                } else {
                    echo "Error: Hostel update failed.";
                }

                $stmt_update_hostel->close();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: Warden registration failed.";
        }

        $stmt_insert_warden->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
