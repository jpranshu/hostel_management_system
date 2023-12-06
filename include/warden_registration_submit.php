<?php

include './connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $warden_id = $_POST['warden_id'];
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $hostel_id = $_POST['hostel_id'];


    $sql_insert_warden = "INSERT INTO warden (warden_id, name, contact_number, email, password, hostel_id) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt_insert_warden = $conn->prepare($sql_insert_warden);

    if ($stmt_insert_warden) {
        $stmt_insert_warden->bind_param("ssisss", $warden_id, $name, $contact_number, $email, $password, $hostel_id);
        $stmt_insert_warden->execute();


        if ($stmt_insert_warden->affected_rows > 0) {

            $sql_update_hostel = "UPDATE hostel SET warden_id = ? WHERE hostel_id = ?";

            $stmt_update_hostel = $conn->prepare($sql_update_hostel);

            if ($stmt_update_hostel) {
                $stmt_update_hostel->bind_param("ss", $warden_id, $hostel_id);
                $stmt_update_hostel->execute();


                if ($stmt_update_hostel->affected_rows > 0) {
                    echo "Warden registered successfully and hostel updated!";


                    $_SESSION['user_id'] = $warden_id;
                    $_SESSION['user_type'] = 'warden';


                    header('Location: ../warden_dashboard.php');
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
}
