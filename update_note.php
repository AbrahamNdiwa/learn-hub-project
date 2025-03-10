<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $query = "UPDATE notes SET title = '$title', content = '$content' WHERE id = '$id'";
    mysqli_query($conn, $query);
    logActivity($_SESSION['user_id'], 'Updated Note', $id);
}
?>
