<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $value = $_POST['value']; // 1 for approve, 2 for reject

    $query = "UPDATE answers SET approved = '$value' WHERE id = '$id'";
    mysqli_query($conn, $query);
}
?>
