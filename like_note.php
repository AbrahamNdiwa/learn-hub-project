<?php
include 'db.php';
session_start();

$note_id = isset($_POST['note_id']) ? intval($_POST['note_id']) : 0;
$user_id = $_SESSION['user_id'];

if (!$note_id) {
    echo json_encode(['error' => 'Invalid note ID']);
    exit();
}

// Check if the user has already liked the note
$like_check = mysqli_query($conn, "SELECT * FROM likes WHERE user_id = $user_id AND note_id = $note_id");
if (mysqli_num_rows($like_check) == 0) {
    // Insert into likes table
    mysqli_query($conn, "INSERT INTO likes (user_id, note_id) VALUES ($user_id, $note_id)");

    // Update likes count in notes table
    mysqli_query($conn, "UPDATE notes SET likes = likes + 1 WHERE id = $note_id");
}

// Get the updated likes count
$likes_result = mysqli_query($conn, "SELECT likes FROM notes WHERE id = $note_id");
$likes = mysqli_fetch_assoc($likes_result)['likes'];

echo json_encode(['likes' => $likes]);
?>
