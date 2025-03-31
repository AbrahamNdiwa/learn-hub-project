<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);

    $query = "UPDATE subjects SET name = '$name', code = '$code' WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "<script>
                alert('Subject Updated.');
                window.location.href = 'dashboard.php';
              </script>";
}
?>
