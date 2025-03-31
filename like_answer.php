<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'You must be logged in to like an answer.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$answer_id = $_POST['answer_id'];

// Check if the user already liked the answer
$check_query = "SELECT * FROM likes WHERE user_id = '$user_id' AND answer_id = '$answer_id'";
$result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($result) == 0) {
    // Add like
    $insert_query = "INSERT INTO likes (user_id, answer_id) VALUES ('$user_id', '$answer_id')";
    mysqli_query($conn, $insert_query);
    echo json_encode(['status' => 'liked']);
} else {
    // Unlike
    $delete_query = "DELETE FROM likes WHERE user_id = '$user_id' AND answer_id = '$answer_id'";
    mysqli_query($conn, $delete_query);
    echo json_encode(['status' => 'unliked']);
}
?>
