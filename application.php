<?php include 'include/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Page</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen">
    <?php include 'include/header.php'; ?>

    <div class="flex flex-wrap w-64 h-64">

        <div class="w-1/2 h-1/2 bg-blue-500">
            <a href="mess_application.php" class="flex items-center justify-center h-full w-full text-white font-bold text-lg">Mess Payment</a>
        </div>

        <div class="w-1/2 h-1/2 bg-green-500">
            <a href="repair_request.php" class="flex items-center justify-center h-full w-full text-white font-bold text-lg">Repair Request</a>
        </div>

        <div class="w-1/2 h-1/2 bg-yellow-500">
            <a href="hostel_request.php" class="flex items-center justify-center h-full w-full text-white font-bold text-lg">Hostel Payment</a>
        </div>

        <div class="w-1/2 h-1/2 bg-red-500">
            <a href="room_reallotment.php" class="flex items-center justify-center h-full w-full text-white font-bold text-lg">Room Reallotment</a>
        </div>
    </div>

</body>

</html>