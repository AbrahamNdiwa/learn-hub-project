<?php
include 'db.php';
session_start();

$note_id = isset($_POST['note_id']) ? intval($_POST['note_id']) : 0;
$user_id = $_SESSION['user_id'];

if (!$note_id || !$user_id) {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}

// Check if the user has already bookmarked the note
$bookmark_check = mysqli_query($conn, "SELECT * FROM bookmarks WHERE user_id = $user_id AND note_id = $note_id");

if (mysqli_num_rows($bookmark_check) > 0) {
    // Remove bookmark
    mysqli_query($conn, "DELETE FROM bookmarks WHERE user_id = $user_id AND note_id = $note_id");
    mysqli_query($conn, "UPDATE notes SET bookmarks = bookmarks - 1 WHERE id = $note_id");
    $bookmarked = false;
} else {
    // Add bookmark
    mysqli_query($conn, "INSERT INTO bookmarks (user_id, note_id) VALUES ($user_id, $note_id)");
    mysqli_query($conn, "UPDATE notes SET bookmarks = bookmarks + 1 WHERE id = $note_id");
    $bookmarked = true;
}

// Get the updated bookmarks count
$bookmark_result = mysqli_query($conn, "SELECT bookmarks FROM notes WHERE id = $note_id");
$bookmarks = mysqli_fetch_assoc($bookmark_result)['bookmarks'];

echo json_encode(['bookmarks' => $bookmarks, 'bookmarked' => $bookmarked]);

// Log bookmark activity
if (mysqli_num_rows($bookmark_check) > 0) {
    logActivity($user_id, 'Removed from Bookmarks', $note_id);
}else{    
    logActivity($user_id, 'Bookmarked Note', $note_id);
}
?>
