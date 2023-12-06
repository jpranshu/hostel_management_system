<?php
include 'include/connect.php';

// Check if the user is logged in as a warden
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'warden') {
    // Redirect to the warden login page if not logged in as a warden
    header('Location: warden_login.php');
    exit();
}

// Retrieve room reallotment applications
$hostelId = $_SESSION['hostel_id'];
$sql = "SELECT * FROM application WHERE type = 'room_reallotment' AND status = 'requested' AND hostel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hostelId);
$stmt->execute();
$result = $stmt->get_result();
$reallotmentApplications = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$conn->close();
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
    <h1 class="text-2xl font-bold mb-4">Warden Dashboard</h1>

    <?php if (!empty($reallotmentApplications)) { ?>
        <table class="table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Application ID</th>
                    <th class="px-4 py-2">Student Roll Number</th>
                    <th class="px-4 py-2">New Room Requested</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reallotmentApplications as $application) { ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo $application['application_id']; ?></td>
                        <td class="border px-4 py-2"><?php echo $application['roll_number']; ?></td>
                        <td class="border px-4 py-2"><?php echo $application['transaction_id']; ?></td>
                        <td class="border px-4 py-2">
                            <form action="include/warden_room_process.php" method="post">
                                <input type="hidden" name="type" value="room_reallotment">
                                <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                                
                                <!-- Select field for approval or denial -->
                                <select name="status" class="p-2 border rounded">
                                    <option value="verified">Approve</option>
                                    <option value="denied">Deny</option>
                                </select>
                                
                                <!-- Input field for remarks -->
                                <input type="text" name="remarks" placeholder="Add remarks" class="p-2 border rounded">
                                
                                <button type="submit" class="p-2 bg-green-500 text-white rounded">Submit</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No room reallotment applications to review.</p>
    <?php } ?>

</div>

</body>
</html>
