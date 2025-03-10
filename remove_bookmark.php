<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$note_id = isset($_POST['note_id']) ? intval($_POST['note_id']) : 0;

if ($note_id > 0) {
    $query = "DELETE FROM bookmarks WHERE user_id = ? AND note_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $note_id);
    
    if ($stmt->execute()) {
        $updateQuery = "UPDATE notes SET bookmarks = bookmarks - 1 WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $note_id);
        $updateStmt->execute();

        echo json_encode(["status" => "success", "message" => "Bookmark removed."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to remove bookmark."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid note ID."]);
}
?>
