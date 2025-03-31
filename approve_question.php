<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $value = mysqli_real_escape_string($conn, $_POST['value']);

    $query = "UPDATE questions SET approved = '$value' WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "<script>
                alert('Question Updated.');
                window.location.href = 'dashboard.php';
              </script>";
}
?>
