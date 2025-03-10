<?php 
include 'db.php';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $new_name = mysqli_real_escape_string($conn, strip_tags($_POST['fullname']) );
        $new_email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
        
        $update_query = "UPDATE users SET fullname='$new_name', email='$new_email' WHERE id='$user_id'";
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['fullname'] = $new_name;
            $_SESSION['email'] = $new_email;
            echo "<script>alert('Profile updated successfully');</script>";
            header("Location: index.php");
        } else {
            echo "<script>alert('Error updating profile');</script>";
            header("Location: index.php");
        }
    }
    
    if (isset($_POST['change_password'])) {
        $current_password = mysqli_real_escape_string($conn, strip_tags($_POST['current_password']) );
        $new_password = mysqli_real_escape_string($conn, strip_tags($_POST['new_password']));
        $confirm_password = mysqli_real_escape_string($conn, strip_tags($_POST['confirm_password']) );
        
        $query = "SELECT password FROM users WHERE id='$user_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        
        if (password_verify($current_password, $row['password'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_pass_query = "UPDATE users SET password='$hashed_password' WHERE id='$user_id'";
                if (mysqli_query($conn, $update_pass_query)) {
                    echo "<script>alert('Password updated successfully');</script>";
                } else {
                    echo "<script>alert('Error updating password');</script>";
                }
            } else {
                echo "<script>alert('New passwords do not match');</script>";
            }
        } else {
            echo "<script>alert('Incorrect current password');</script>";
        }
    }
}

?>