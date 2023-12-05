<?php include 'include/connect.php';
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Pranshu Jaiswal"> 
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="fonts/material-icons.css" rel="stylesheet">
        <link href="include/main.css" rel="stylesheet" type="text/css"/>
        
        <title>Student Register</title>
    </head>

<body>
<?php include 'include/header.php'?>
  <div class="container mx-auto p-8 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Student Login</h1>

    <form action="include/student_login_submit.php" method="post">
      <!-- Roll Number -->
      <div class="mb-4">
        <label for="roll_number" class="block text-sm font-semibold text-gray-600">Roll Number</label>
        <input type="text" id="roll_number" name="roll_number" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Password -->
      <div class="mb-6">
        <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
        <input type="password" id="password" name="password" class="w-full mt-1 p-2 border rounded-md" required>
      </div>

      <!-- Submit Button -->
      <div class="mb-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Login</button>
      </div>
    </form>
  </div>

</body>
</html>
