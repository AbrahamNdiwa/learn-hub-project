<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'] ?? null;
    $is_admin = $_SESSION['is_admin'] ?? false;

    if (!$user_id) {
        echo "Unauthorized";
        exit();
    }

    // Check if the user is the owner or an admin
    $check_query = "SELECT user_id FROM questions WHERE id = '$id'";
    $result = mysqli_query($conn, $check_query);
    $row = mysqli_fetch_assoc($result);

    if ($row && ($row['user_id'] == $user_id || $is_admin)) {
        $query = "DELETE FROM questions WHERE id = '$id'";
        mysqli_query($conn, $query);
        echo "Deleted";
    } else {
        echo "Unauthorized";
    }
}
?>
