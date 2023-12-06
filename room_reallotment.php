<?php
// S
// Include your database connection file
include 'include/connect.php';

session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    // Redirect to the student login page if not logged in as a student
    header('Location: student_login.php');

}


// Get the student's ID from the session
$studentId = $_SESSION['user_id'];

// Retrieve the student's current room details
$sql = "SELECT room_number, hostel_id FROM room WHERE student_1 = ? OR student_2 = ? OR student_3 = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $studentId, $studentId, $studentId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the student is currently allocated to a room
if ($result->num_rows > 0) {
    $currentRoom = $result->fetch_assoc();
}

// Retrieve available rooms for reallotment
$sql = "SELECT room_number, hostel_id, capacity FROM room WHERE (student_1 IS NULL OR student_2 IS NULL OR student_3 IS NULL) AND (hostel_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentRoom['hostel_id']);
$stmt->execute();
$availableRooms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Reallotment Application</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body>

<?php include 'include/header.php'; ?>

<div class="container mx-auto mt-[10vh]">
    <h1 class="text-2xl font-bold mb-4">Room Reallotment Application</h1>

    <?php if (isset($currentRoom)) { ?>
        <p><strong>Current Room:</strong> <?php echo $currentRoom['room_number']; ?></p>
        <form action="include/room_process.php" method="post">
            <input type="hidden" name="type" value="room_reallotment">
            <input type="hidden" name="hostel_id" value="<?php echo $currentRoom['hostel_id']; ?>">
            <input type="hidden" name="room_number" value="<?php echo $currentRoom['room_number']; ?>">
            <input type="hidden" name="description" value="Room Reallotment Application">
            <input type="hidden" name="current_room" value="<?php echo $currentRoom['room_number']; ?>">
            <label for="new_room" class="block mt-4">Select a new room:</label>
            <select name="new_room" id="new_room" class="p-2 border rounded">
                <?php foreach ($availableRooms as $room) { ?>
                    <?php if ($room['capacity'] > 0) { ?>
                        <option value="<?php echo $room['room_number']; ?>"><?php echo $room['room_number']; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <button type="submit" class="p-2 bg-blue-500 text-white rounded mt-4">Submit Application</button>
        </form>
    <?php } else { ?>
        <p>Error: Student not allocated to a room.</p>
    <?php } ?>

</div>

</body>
</html>
