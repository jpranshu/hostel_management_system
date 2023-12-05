<?php include 'include/connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warden Registration Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'include/header.php'?>

  <div class="container mx-auto p-8 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Warden Registration Form</h1>

    <form action="include/warden_registration_submit.php" method="post">
      <!-- Warden ID -->
      <div class="mb-4">
        <label for="warden_id" class="block text-sm font-semibold text-gray-600">Warden ID</label>
        <input type="text" id="warden_id" name="warden_id" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Name -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-semibold text-gray-600">Name</label>
        <input type="text" id="name" name="name" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Contact Number -->
      <div class="mb-4">
        <label for="contact_number" class="block text-sm font-semibold text-gray-600">Contact Number</label>
        <input type="tel" id="contact_number" name="contact_number" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
        <input type="email" id="email" name="email" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Password -->
      <div class="mb-6">
        <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
        <input type="password" id="password" name="password" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Hostel ID -->
      <div class="mb-4">
        <label for="hostel_id" class="block text-sm font-semibold text-gray-600">Hostel ID</label>
        <input type="text" id="hostel_id" name="hostel_id" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Submit Button -->
      <div class="mb-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Register</button>
      </div>
    </form>
  </div>

</body>
</html>
