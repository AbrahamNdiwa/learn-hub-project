<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $note_id = $_POST['id'];
    $query = "DELETE FROM notes WHERE id = '$note_id'";
    mysqli_query($conn, $query);
}
logActivity($_SESSION['user_id'], 'Deleted Note', $note_id);

?>
