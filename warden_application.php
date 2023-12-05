<?php
include 'include/connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'warden') {
    header('Location: warden_login.php');
    exit();
}

$wardenId = $_SESSION['user_id'];
$hostelId = $_SESSION['hostel_id'];

$sql = "SELECT application_id, roll_number, type, description, status, room_number, remark FROM application WHERE hostel_id = ? AND status=?";
$stmt = $conn->prepare($sql);
$state = 'requested';
$stmt->bind_param("ss", $hostelId, $state);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $applications = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $applications = [];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Application Dashboard</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>

<body class="bg-gray-100 ">

    <?php include 'include/header.php'; ?>

    <div class="container mx-auto mt-[10vh]">
        <h1 class="text-2xl font-bold mb-4">Warden Application Dashboard - <?php echo $hostelId ?></h1>

        <?php if (!empty($applications)) { ?>
            <?php foreach ($applications as $application) { ?>
                <div class="bg-white p-4 mb-4 shadow-md">
                    <h2 class="text-xl font-semibold mb-2"><?php echo ucfirst($application['type']); ?> Application</h2>
                    <p><strong>Application ID:</strong> <?php echo $application['application_id']; ?></p>
                    <p><strong>Roll Number:</strong> <?php echo $application['roll_number']; ?></p>
                    <p><strong>Description:</strong> <?php echo $application['description']; ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst($application['status']); ?></p>
                    <p><strong>Room Number:</strong> <?php echo $application['room_number']; ?></p>
                    <p><strong>Remark:</strong> <?php echo $application['remark']; ?></p>

                    <form action="include/update_application_status.php" method="post">
                        <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                        <div class="flex items-center space-x-4 mt-2">
                            <select name="status" class="p-2 border rounded">
                                <option value="verified">Verified</option>
                                <option value="denied">Denied</option>
                                <option value="remark_only">remark Only</option>
                            </select>
                            <input type="text" name="remark" placeholder="remark" class="p-2 border rounded">
                            <button type="submit" class="p-2 bg-blue-500 text-white rounded">Update Status</button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No applications found in the hostel.</p>
        <?php } ?>

    </div>

</body>

</html>