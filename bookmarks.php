<?php
include 'db.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id) {
    echo "<p>Please log in to view your bookmarked notes.</p>";
    exit();
}

$query = "SELECT n.id, n.title, n.content, n.likes, n.views, n.bookmarks FROM bookmarks b JOIN notes n ON b.note_id = n.id WHERE b.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarked Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-10">
        <h2>Bookmarked Notes</h2>
        <div class="list-group mt-2">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="list-group-item mt-3">
                    <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    <p>Likes: <?php echo $row['likes']; ?> | Views: <?php echo $row['views']; ?> | Bookmarks: <?php echo $row['bookmarks']; ?></p>
                    <button class="btn btn-danger remove-bookmark" data-id="<?php echo $row['id']; ?>">Remove Bookmark</button>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.remove-bookmark').click(function() {
                var noteId = $(this).data('id');
                $.post('remove_bookmark.php', { note_id: noteId }, function(response) {
                    location.reload();
                });
            });
        });
    </script>
</body>
</html>