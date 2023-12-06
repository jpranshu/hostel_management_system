<?php include_once 'include/connect.php';
$popupMessage = isset($_GET['message']) ? urldecode($_GET['message']) : '';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header('Location: student_login.php');
    exit();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <script>
        var popupMessage = '<?php echo $popupMessage; ?>';
        if (popupMessage.trim() !== '') {

            alert(popupMessage);
        }
    </script>

    <?php

    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {

        header('Location: student_login.php');
        exit();
    }

    $studentId = $_SESSION['user_id'];

    $sqlStudent = "SELECT roll_number, name, email, contact_number, gender, hostel_id, room_number FROM student WHERE roll_number = ?";
    $stmtStudent = $conn->prepare($sqlStudent);
    $stmtStudent->bind_param("s", $studentId);
    $stmtStudent->execute();
    $resultStudent = $stmtStudent->get_result();

    if ($resultStudent->num_rows > 0) {
        $studentData = $resultStudent->fetch_assoc();
    }

    $stmtStudent->close();

    $sqlApplications = "SELECT * FROM application WHERE roll_number = ? ORDER BY application_id DESC LIMIT 10";
    $stmtApplications = $conn->prepare($sqlApplications);
    $stmtApplications->bind_param("s", $studentId);
    $stmtApplications->execute();
    $resultApplications = $stmtApplications->get_result();
    ?>

    <?php if (isset($studentData) && $studentData) { ?>
        <?php include 'include/header.php'; ?>
        <div class="container mx-auto mt-[15vh] p-8 bg-white max-w-md rounded-md shadow-md">
            <h1 class="text-2xl font-bold mb-6">Student Details</h1>
            <ul class="space-y-4">
                <li><strong>Name:</strong> <?php echo $studentData['name']; ?></li>
                <li><strong>Roll Number:</strong> <?php echo $studentData['roll_number']; ?></li>
                <li><strong>Contact Number:</strong> <?php echo $studentData['contact_number']; ?></li>
                <li><strong>Gender:</strong> <?php echo $studentData['gender']; ?></li>
                <li><strong>Email:</strong> <?php echo $studentData['email']; ?></li>
                <li><strong>Hostel ID:</strong> <?php echo $studentData['hostel_id']; ?></li>
                <li><strong>Room Number:</strong> <?php echo $studentData['room_number']; ?></li>
            </ul>
        </div>

        <?php if ($resultApplications->num_rows > 0) { ?>
            <div class="container mx-auto mt-8 mb-8 p-8 bg-white max-w-md rounded-md shadow-md">
                <h1 class="text-2xl font-bold mb-6">Last 10 Applications</h1>
                <ul class="space-y-4">
                    <?php while ($application = $resultApplications->fetch_assoc()) { ?>
                        <li><strong>Application ID:</strong> <?php echo $application['application_id']; ?></li>
                        <li><strong>Type:</strong> <?php echo $application['type']; ?></li>
                        <li><strong>Description:</strong> <?php echo $application['description']; ?></li>
                        <li><strong>Transaction ID:</strong> <?php echo $application['transaction_id']; ?></li>
                        <li><strong>Status:</strong> <?php echo $application['status']; ?></li>
                        <li><strong>Remarks:</strong> <?php echo $application['remark']; ?></li>
                        <hr>
                    <?php } ?>
                </ul>
            </div>
        <?php } else { ?>
            <p class="mt-8 text-center text-xl font-semibold">No recent applications found.</p>
        <?php } ?>
    <?php } else { ?>
        <p class="mt-12 text-center text-xl font-semibold">Error: Student not found.</p>
    <?php } ?>

</body>

</html>