<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $note_id = $_POST['id'];
    $query = "SELECT * FROM notes WHERE id = '$note_id'";
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    }
}
?>
