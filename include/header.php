<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="include/main.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Hostel Management System</title>
</head>

<body>
  <header class="fixed top-0 left-0 right-0 bg-red-800 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
      <a href="index.php">
        <h1 class="text-2xl font-bold">Hostel Management</h1>
      </a>
      <nav class="flex space-x-4">
        <?php


        use function PHPSTORM_META\type;

        if (isset($_SESSION['user_id'])) {
          $userId = $_SESSION['user_id'];
          $userType = $_SESSION['user_type'];

          echo '<div class="flex items-center mr-4">';
          if ($userType == 'warden') {
            echo '<a href="warden_dashboard.php"><span class="mr-2 text-gray-300">Welcome, ' . $userId . ' (' . ucfirst($userType) . ')</span></a>';
          } else if ($userType == 'student') {
            echo '<a href="student_dashboard.php"><span class="mr-2 text-gray-300">Welcome, ' . $userId . ' (' . ucfirst($userType) . ')</span></a>';
          }

          echo '</div>';


          if ($userType === 'student') {
            echo '<a href="./application.php" class="flex items-center hover:text-gray-300">
                            <i class="fas fa-file"></i>
                            <span class="ml-1">Application</span>
                          </a>';
            echo '<a href="update_details.php" class="flex items-center hover:text-gray-300">
                            <i class="fas fa-user-edit"></i>
                            <span class="ml-1">Update Details</span>
                          </a>';
          } elseif ($userType === 'warden') {
            echo '<a href="warden_application.php" class="flex items-center hover:text-gray-300">
                            <i class="fas fa-file-alt"></i>
                            <span class="ml-1">Applications</span>
                          </a>';
          }


          echo '<a href="./logout.php" class="flex items-center hover:text-gray-300">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="ml-1">Logout</span>
                      </a>';
        } else {

          echo '<a href="./student_register.php" class="flex items-center hover:text-gray-300">
                        <i class="fa fa-user"></i>
                        <span class="ml-1">Student Registration</span>
                      </a>';
          echo '<a href="./student_login.php" class="flex items-center hover:text-gray-300">
                        <i class="fas fa-user"></i>
                        <span class="ml-1">Student Login</span>
                      </a>';
          echo '<a href="./warden_registration.php" class="flex items-center hover:text-gray-300">
                        <i class="fas fa-users"></i>
                        <span class="ml-1">Warden Registration</span>
                      </a>';
          echo '<a href="./warden_login.php" class="flex items-center hover:text-gray-300">
                      <i class="fas fa-users"></i>
                      <span class="ml-1">Warden Login</span>
                    </a>';
          echo '<a href="#" class="flex items-center hover:text-gray-300">
                        <i class="fas fa-envelope"></i>
                        <span class="ml-1">Contact</span>
                      </a>';
        }
        ?>
      </nav>
    </div>
  </header>

</body>

</html>