<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $subject_id = $_POST['id'];
    $query = "DELETE FROM subjects WHERE id = '$subject_id'";
    mysqli_query($conn, $query);
}
?>
