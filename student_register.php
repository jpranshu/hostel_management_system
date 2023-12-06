<?php include 'include/connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Pranshu Jaiswal">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="fonts/material-icons.css" rel="stylesheet">
    <link href="include/main.css" rel="stylesheet" type="text/css" />

    <title>Student Registration</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <?php include 'include/header.php'; ?>

    <div class="container mx-auto p-8 max-w-md bg-white rounded-md shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-500">Student Registration Form</h1>

        <form action="include/student_register_submit.php" method="post" class="space-y-4">
            <div>
                <label for="roll_number" class="block text-sm font-semibold text-gray-600">Roll Number</label>
                <input type="text" id="roll_number" name="roll_number" class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-600">Name</label>
                <input type="text" id="name" name="name" class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <div>
                <label for="gender" class="block text-sm font-semibold text-gray-600">Gender</label>
                <select id="gender" name="gender" class="w-full mt-1 p-2 border rounded-md" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>

            <div>
                <label for="contact_number" class="block text-sm font-semibold text-gray-600">Contact Number</label>
                <input type="tel" id="contact_number" name="contact_number" class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                <input type="email" id="email" name="email" class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <div>
                <label for="hostel_id" class="block text-sm font-semibold text-gray-600">Hostel ID</label>
                <input type="text" id="hostel_id" name="hostel_id" class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <div>
                <label for="room_number" class="block text-sm font-semibold text-gray-600">Room Number</label>
                <input type="text" id="room_number" name="room_number" placeholder="000 if not allotted"
                    class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
                <input type="password" id="password" name="password" class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Register</button>
            </div>
        </form>
    </div>

</body>

</html>
