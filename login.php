<?php
include 'db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $jcu_number = clean_user_data($_POST['jcu_number']);
    $password = clean_user_data($_POST['password']);
    
    $result = $conn->query("SELECT * FROM users WHERE jcu_number='$jcu_number'");
    $user = $result->fetch_assoc();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['jcu_number'] = $user['jcu_number'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
    } else {
        echo "<script>
                alert('Invalid Credentials.');
                window.location.href = 'login_page.php';
              </script>";
    }
}
?>
