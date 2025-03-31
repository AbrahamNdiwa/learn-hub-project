<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $approved = 0;

    if($_SESSION['role'] == 'admin')
    {
        $approved = 1;
    }

    $query = "UPDATE answers SET content = '$content', approved = '$approved' WHERE id = '$id' AND user_id = '{$_SESSION['user_id']}'";
    mysqli_query($conn, $query);

    echo "Success";
}
?>
