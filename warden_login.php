<?php include 'include/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <?php include 'include/header.php'; ?>
    <div class="max-w-md w-full p-8 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-8">Warden Login</h2>


        <form action="include/warden_login_submit.php" method="post">
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<p class="text-red-500">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']);
            }
            ?>

            <div class="mb-4">
                <label for="warden_id" class="block text-sm font-semibold text-gray-600">Warden ID</label>
                <input type="text" id="warden_id" name="warden_id" class="w-full mt-1 p-2 border rounded-md" required>
            </div>


            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
                <input type="password" id="password" name="password" class="w-full mt-1 p-2 border rounded-md" required>
            </div>


            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Login</button>
            </div>
        </form>
    </div>

</body>

</html>