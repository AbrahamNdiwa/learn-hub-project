<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Unauthorized";
    exit;
}

$question_id = $_POST['id'];
$new_status = $_POST['hidden'] == 1 ? 0 : 1;

$query = "UPDATE questions SET hidden = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $new_status, $question_id);

if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error";
}
?>
