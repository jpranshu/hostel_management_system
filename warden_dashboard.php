<?php
include 'include/connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'warden') {
    header('Location: warden_login.php');
    exit();
}

$wardenId = $_SESSION['user_id'];
$hostelId = $_SESSION['hostel_id'];

// Query to count pending applications
$sqlCountPending = "SELECT COUNT(*) AS pending_count FROM application WHERE hostel_id = ? AND status = 'requested'";
$stmtCountPending = $conn->prepare($sqlCountPending);
$stmtCountPending->bind_param("s", $hostelId);
$stmtCountPending->execute();
$resultCountPending = $stmtCountPending->get_result();

// Fetch the count of pending applications
if ($rowCountPending = $resultCountPending->fetch_assoc()) {
    $pendingCount = $rowCountPending['pending_count'];
} else {
    $pendingCount = 0;
}

$stmtCountPending->close();

// Query to retrieve room details
$sqlRooms = "SELECT room_number, student_1, student_2, student_3 FROM room WHERE hostel_id = ?";
$stmtRooms = $conn->prepare($sqlRooms);
$stmtRooms->bind_param("s", $hostelId);
$stmtRooms->execute();
$resultRooms = $stmtRooms->get_result();

// Fetch room details
if ($resultRooms->num_rows > 0) {
    $rooms = $resultRooms->fetch_all(MYSQLI_ASSOC);
} else {
    $rooms = [];
}

$stmtRooms->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Dashboard</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

<?php include 'include/header.php'; ?>

<div class="container mx-auto mt-[10vh]">
    <h1 class="text-2xl font-bold mb-4">Warden Dashboard - <?php echo $hostelId?></h1>

    <div class="mb-4">
        <p class="text-lg">Pending Applications: <span class="font-bold text-red-500"><?php echo $pendingCount; ?></span></p>
    </div>

    <?php if (!empty($rooms)) { ?>
        <table class="w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Room Number</th>
                    <th class="p-2 border">Student 1</th>
                    <th class="p-2 border">Student 2</th>
                    <th class="p-2 border">Student 3</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room) { ?>
                    <tr>
                        <td class="p-2 border"><?php echo $room['room_number']; ?></td>
                        <td class="p-2 border"><?php echo $room['student_1']; ?></td>
                        <td class="p-2 border"><?php echo $room['student_2']; ?></td>
                        <td class="p-2 border"><?php echo $room['student_3']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No rooms found in the hostel.</p>
    <?php } ?>

</div>

</body>
</html>
