<?php
include './connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $applicationId = $_POST['application_id'];
    $status = $_POST['status'];
    $remarks = $_POST['remark'];


    $updateSql = "";
    $bindType = "";

    switch ($status) {
        case 'verified':
        case 'denied':
            $updateSql = "UPDATE application SET status = ?, remark = ? WHERE application_id = ?";
            $bindType = "ssi";
            break;
        case 'remark_only':
            $updateSql = "UPDATE application SET remark = ? WHERE application_id = ?";
            $bindType = "si";
            break;
    }

    $updateStmt = $conn->prepare($updateSql);

    if ($updateStmt) {
        if ($bindType === "ssi") {
            $updateStmt->bind_param($bindType, $status, $remarks, $applicationId);
        } elseif ($bindType === "si") {
            $updateStmt->bind_param($bindType, $remarks, $applicationId);
        }

        $updateStmt->execute();
        $updateStmt->close();
    }

    header('Location: ../warden_application.php');
    exit();
} else {
    header('Location: ../warden_application.php');
    exit();
}
