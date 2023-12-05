<?php
include './connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $warden_id = $_POST['warden_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM warden WHERE warden_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $warden_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['warden_id'];
            $_SESSION['user_type'] = 'warden';
            $_SESSION['hostel_id'] = $row['hostel_id'];
            header('Location: ../warden_dashboard.php');
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid password. Please try again.";
        }
    } else {
        $_SESSION['login_error'] = "Warden with ID $warden_id does not exist.";
    }

    $stmt->close();

    header('Location: ../warden_login.php');
    exit();
}
?>
