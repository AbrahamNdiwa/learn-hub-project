<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $query = "DELETE FROM answers WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "Deleted";
}
?>
