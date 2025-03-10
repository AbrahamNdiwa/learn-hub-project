<?php
include 'db.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id) {
    echo "<p>Please log in to view your bookmarked notes.</p>";
    exit();
}

// Get total notes, total views, and total bookmarks for the user's notes
$stats_query = "SELECT 
    (SELECT COUNT(*) FROM notes WHERE user_id = ?) AS total_notes,
    (SELECT SUM(views) FROM notes WHERE user_id = ?) AS total_views,
    (SELECT SUM(bookmarks) FROM notes WHERE user_id = ?) AS total_bookmarks";
$stmt_stats = $conn->prepare($stats_query);
$stmt_stats->bind_param("iii", $user_id, $user_id, $user_id);
$stmt_stats->execute();
$stats_result = $stmt_stats->get_result()->fetch_assoc();

$total_notes = $stats_result['total_notes'] ?? 0;
$total_views = $stats_result['total_views'] ?? 0;
$total_bookmarks = $stats_result['total_bookmarks'] ?? 0;

// Get bookmarked notes
$query = "SELECT n.id, n.title, n.content, n.likes, n.views, n.bookmarks FROM bookmarks b JOIN notes n ON b.note_id = n.id WHERE b.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Get recent activity
$activitiesQuery = "SELECT a.action, a.created_at, n.title 
                    FROM activity a 
                    LEFT JOIN notes n ON a.note_id = n.id 
                    WHERE a.user_id = ? 
                    ORDER BY a.created_at DESC LIMIT 4";
$stmt1 = $conn->prepare($activitiesQuery);
$stmt1->bind_param("i", $_SESSION['user_id']);
$stmt1->execute();
$result1 = $stmt1->get_result();
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
    <div class="container mt-2">
        <h2>Dashboard</h2>
        <div class="row mt-2">
            <div class="col-md-4 mb-2">
                <div class="card p-3">
                    <h5>Total Notes</h5>
                    <p><?php echo $total_notes; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card p-3">
                    <h5>Total Views</h5>
                    <p><?php echo $total_views; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card p-3">
                    <h5>Total Bookmarks</h5>
                    <p><?php echo $total_bookmarks; ?></p>
                </div>
            </div>
        </div>
        <h4 class="mt-4">Recent Activity</h4>
            <div class="mt-2">
                <?php while($row = $result1->fetch_assoc()): ?>
                    <div class="col-md-6 mb-2">
                        <div class="card p-2">
                            <h6><?= $row['action'] . ' : "' . ($row['title'] ?? 'N/A'). '"' ?></h6>
                            <p><?= date("d M Y, h.iA", strtotime($row['created_at'])) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            <a href="#" class="btn btn-primary load-page" data-page="add_note.php">Create New Note</a>
            <a href="browse.php" class="btn btn-secondary">Browse Notes</a>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.menu-item').click(function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $('#main-content').load(target + '.php');
            });

            $('.load-page').click(function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                $('#main-content').load(page);
            });
        });

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
