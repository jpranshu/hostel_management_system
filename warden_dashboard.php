<?php
include 'include/connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'warden') {
    header('Location: warden_login.php');
    exit();
}

$wardenId = $_SESSION['user_id'];
$hostelId = $_SESSION['hostel_id'];


$sql = "SELECT room_number, student_1, student_2, student_3 FROM room WHERE hostel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hostelId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $rooms = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rooms = [];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Dashboard</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body>

<?php include 'include/header.php'; ?>

<div class="container mx-auto mt-[10vh]">
    <h1 class="text-2xl font-bold mb-4">Warden Dashboard - <?php echo $hostelId?></h1>

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
