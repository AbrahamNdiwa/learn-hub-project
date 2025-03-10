<?php
include 'db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = clean_user_data($_POST['email']);
    $password = clean_user_data($_POST['password']);
    
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['email'] = $user['email'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid credentials";
    }
}
?>
