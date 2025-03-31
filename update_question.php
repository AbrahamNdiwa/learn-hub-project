<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $user_id = $_SESSION['user_id'] ?? null;

    // Ensure the user is logged in
    if (!$user_id) {
        echo "Unauthorized";
        exit();
    }

    // Check if user is the owner
    $check_query = "SELECT user_id FROM questions WHERE id = '$id'";
    $result = mysqli_query($conn, $check_query);
    $row = mysqli_fetch_assoc($result);
    $approved = 0;

    if($_SESSION['role'] == 'admin')
    {
        $approved = 1;
    }

    if ($row['user_id'] == $user_id) {
        $query = "UPDATE questions SET question = '$content', approved = '$approved' WHERE id = '$id'";
        mysqli_query($conn, $query);
        echo "Success";
    } else {
        echo "Unauthorized";
    }
}
?>
