<?php include 'include/connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Request Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <?php include 'include/header.php' ?>

    <div class="container mx-auto mt-12 p-8 bg-white max-w-md rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-6">Repair Request Application</h2>

        <form action="include/process_application.php" method="post">
            <input type="hidden" name="type" value="repair_request" class="hidden">
            
            <!-- Description Field -->
            <div class="mb-4">
    <label for="description" class="block text-sm font-semibold text-gray-600">Description</label>
    <textarea name="description" id="description" placeholder="Description" required
        class="w-full mt-1 p-2 border rounded-md resize-none focus:outline-none focus:ring focus:border-blue-300"></textarea>
</div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                    Submit Application
                </button>
            </div>
        </form>
    </div>

</body>
</html>
