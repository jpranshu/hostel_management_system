<?php include 'include/connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Allocation Details</title>
    <!-- Add Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">

<?php
// Start the session
include 'include/connect.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    // Redirect to the student login page if not logged in as a student
    header('Location: student_login.php');
    exit();
}

// Get the student's ID from the session
$studentId = $_SESSION['user_id'];

// Retrieve the hostel and room details for the student
$sql = "SELECT student.roll_number,student.name, student.email,student.contact_number,student.gender, room.room_number, room.hostel_id
        FROM room
        JOIN student ON room.hostel_id = student.hostel_id
        WHERE student.roll_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the student exists and is allocated to a room
if ($result->num_rows > 0) {
    $roomData = $result->fetch_assoc();
}

// Close the database connection
$stmt->close();
?>

<?php if (isset($roomData) && $roomData) {
    include 'include/header.php'; ?>
    <div class="container mx-auto mt-12 p-8 bg-white max-w-md rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-6">Room Allocation Details</h1>
        <ul class="space-y-4">
            <li><strong>Name:</strong> <?php echo $roomData['name']; ?></li>
            <li><strong>Roll Number:</strong> <?php echo $roomData['roll_number']; ?></li>
            <li><strong>Contact Number:</strong> <?php echo $roomData['contact_number']; ?></li>
            <li><strong>Gender:</strong> <?php echo $roomData['gender']; ?></li>
            <li><strong>Email:</strong> <?php echo $roomData['email']; ?></li>
            <li><strong>Room Number:</strong> <?php echo $roomData['room_number']; ?></li>
            <li><strong>Hostel ID:</strong> <?php echo $roomData['hostel_id']; ?></li>
        </ul>
    </div>
<?php } else { ?>
    <p class="mt-12 text-center text-xl font-semibold">Error: Student not allocated to a room.</p>
<?php } ?>

</body>
</html>
