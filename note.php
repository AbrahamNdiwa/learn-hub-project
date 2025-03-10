<?php
include 'db.php';
session_start();

$note_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$note_query = "SELECT * FROM notes WHERE id = $note_id";
$result = mysqli_query($conn, $note_query);
$note = mysqli_fetch_assoc($result);

if (!$note) {
    echo "<p>Note not found.</p>";
    exit();
}

// Update views count
mysqli_query($conn, "UPDATE notes SET views = views + 1 WHERE id = $note_id");

// Check if user has already liked the note
$liked = false;
if ($user_id) {
    $like_check = mysqli_query($conn, "SELECT * FROM likes WHERE user_id = $user_id AND note_id = $note_id");
    $liked = mysqli_num_rows($like_check) > 0;
}

// Check if user has already bookmarked the note
$bookmarked = false;
if ($user_id) {
    $bookmark_check = mysqli_query($conn, "SELECT * FROM bookmarks WHERE user_id = $user_id AND note_id = $note_id");
    $bookmarked = mysqli_num_rows($bookmark_check) > 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($note['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="./images/favicon.ico">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 mx-10">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./images/logo.png" width="100px" height="50px" class="img-fluid rounded float-start" />
            </a>
            <div class="ms-auto">
                <?php if ($user_id): ?>
                    <a href="dashboard.php" class="btn btn-outline-primary">Dashboard</a>
                <?php else: ?>
                    <a href="login_page.php" class="btn btn-outline-primary">Login</a>
                    <a href="register_page.php" class="btn btn-primary">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2><?php echo htmlspecialchars($note['title']); ?></h2>
        <p><small>Views: <?= $note['views'] ?> | Likes: <?= $note['likes'] ?> | Bookmarks: <?= $note['bookmarks'] ?></small></p>
        <div class="mb-4">
            <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
        </div>
        
        <?php if ($user_id): ?>
            <button class="btn btn-primary" id="like-btn" <?php echo $liked ? 'disabled' : ''; ?>><?php echo $liked ? 'Liked' : 'Like'; ?></button>
            <button class="btn btn-warning" id="bookmark-btn"> <?php echo $bookmarked ? 'Remove Bookmark' : 'Bookmark'; ?> </button>
            
        <?php else: ?>
            <p class="text-danger">Login <a href="login_page.php">here</a> to like or bookmark this note.</p>
        <?php endif; ?>
    </div>

    <script>
        $('#like-btn').click(function() {
            $.post('like_note.php', { note_id: <?php echo $note_id; ?> }, function(response) {
                $('#like-count').text(response.likes);
                $('#like-btn').prop('disabled', true).text('Liked');
            }, 'json');
        });

        $('#bookmark-btn').click(function() {
            $.post('bookmark_note.php', { note_id: <?php echo $note_id; ?> }, function(response) {
                $('#bookmark-count').text(response.bookmarks);
                $('#bookmark-btn').text(response.bookmarked ? 'Remove Bookmark' : 'Bookmark');
            }, 'json');
        });
    </script>
</body>
</html>
