<?php
include 'db.php';

$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

$sql = "SELECT * FROM notes WHERE 1";

if (!empty($query)) {
    $sql .= " AND (title LIKE '%$query%' OR content LIKE '%$query%')";
}

if (!empty($category)) {
    $sql .= " AND category = '$category'";
}

$sql .= " ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

echo "<h4>Search Results</h4>";

if (mysqli_num_rows($result) > 0) {
    while ($note = mysqli_fetch_assoc($result)) {
        echo "<div class='card p-3 mb-3'>";
        echo "<h5><a href='note.php?id=" . $note['id'] . "'>" . htmlspecialchars($note['title']) . "</a></h5>";
        echo "<p>" . htmlspecialchars(substr($note['content'], 0, 75)) . "...</p>";
        echo "<p><small>Views: " . $note['views'] . " | Likes: " . $note['likes'] . " | Bookmarks: " . $note['bookmarks'] . "</small></p>";
        echo "</div>";
    }
} else{
    echo '<p class="mt-3">No results found.</p>';
}
?>
