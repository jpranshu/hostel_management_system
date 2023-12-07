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
  <header class="fixed top-0 left-0 right-0 bg-white shadow dark:bg-gray-900 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex justify-between items-center">
      <img width="64" height="64" src="https://img.icons8.com/cotton/64/skyscrapers--v2.png" alt="skyscrapers--v2"/>
      <a href="index.php">
        <h1 class="text-2xl font-bold px-3">Hostel Management</h1>
      </a>
      </div>

      <nav class="flex space-x-4">
        <?php
        if (isset($_SESSION['user_id'])) {
          $userId = $_SESSION['user_id'];
          $userType = $_SESSION['user_type'];

          echo '<div class="flex items-center mr-4">';
          if ($userType == 'warden') {
            echo '<a href="warden_dashboard.php"><span class="mr-2 hover:text-gray-300">Welcome, ' . $userId . ' (' . ucfirst($userType) . ')</span></a>';
          } else if ($userType == 'student') {
            echo '<a href="student_dashboard.php"><span class="mr-2 hover:text-gray-300">Welcome, ' . $userId . ' (' . ucfirst($userType) . ')</span></a>';
          }

          echo '</div>';



          if ($userType === 'student') {
            // echo '<a href="update_details.php" class="flex items-center hover:text-gray-300">
            //                 <i class="fas fa-user-edit"></i>
            //                 <span class="ml-1">Update Details</span>
            //               </a>';
            echo '<div class="dropdown inline-block relative">
                          <button class="bg-white shadow dark:bg-gray-900 hover:text-gray-300  py-2 px-4 rounded inline-flex items-center">
                            <span class="mr-1">Application</span>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                              <path d="M5 10L10 15L15 10H5z" />
                            </svg>
                          </button>
                          <ul class="dropdown-menu absolute hidden pt-1">
                            <li><a class="rounded-t bg-white shadow dark:bg-gray-900 hover:bg-red-600 py-2 px-4 block whitespace-no-wrap" href="./mess_application.php">Mess Payment</a></li>
                            <li><a class="bg-white shadow dark:bg-gray-900 hover:bg-red-600 py-2 px-4 block whitespace-no-wrap" href="./room_reallotment.php">Room Reallocation</a></li>
                            <li><a class="bg-white shadow dark:bg-gray-900 hover:bg-red-600 py-2 px-4 block whitespace-no-wrap" href="./repair_request.php">Repair Request</a></li>
                            <li><a class="rounded-b bg-white shadow dark:bg-gray-900 hover:bg-red-600 py-2 px-4 block whitespace-no-wrap" href="hostel_request.php">Hostel Payment</a></li>
                          </ul>
                        </div>';
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var dropdowns = document.querySelectorAll('.dropdown');

      dropdowns.forEach(function(dropdown) {
        var button = dropdown.querySelector('button');
        var menu = dropdown.querySelector('.dropdown-menu');

        button.addEventListener('click', function() {
          menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
          if (!dropdown.contains(event.target)) {
            menu.classList.add('hidden');
          }
        });
      });
    });
  </script>

</body>

</html>