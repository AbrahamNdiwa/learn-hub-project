<?php
include 'db.php';
session_start();

// Pagination setup
$limit = 6; // Notes per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Get notes for the current page
$notesQuery = "SELECT * FROM notes ORDER BY created_at DESC LIMIT $start, $limit";
$notes = mysqli_query($conn, $notesQuery);

// Get total notes count for pagination
$countQuery = "SELECT COUNT(id) AS total FROM notes";
$countResult = mysqli_query($conn, $countQuery);
$totalNotes = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalNotes / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Notes - LearnHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./images/favicon.ico">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./images/logo.png" width="100px" height="50px" class="img-fluid rounded float-start" />
            </a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-outline-primary me-2">Home</a>
                <a href="dashboard.php" class="btn btn-outline-success">Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Browse Notes</h2>
        
        <div class="text-center mb-4">
            <input type="text" id="search" class="form-control rounded-pill w-100 mx-auto" placeholder="Search notes...">
        </div>

        <div id="searchResults"></div>

        <div id="notesList">
            <div class="row">
                <?php while ($note = mysqli_fetch_assoc($notes)): ?>
                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <h5><a href="note.php?id=<?php echo $note['id']; ?>"><?php echo htmlspecialchars($note['title']); ?></a></h5>
                            <p><?php echo htmlspecialchars(substr($note['content'], 0, 100)); ?>...</p>
                            <p><small>Views: <?= $note['views'] ?> | Likes: <?= $note['likes'] ?> | Bookmarks: <?= $note['bookmarks'] ?></small></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center mt-3">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <script src="script/browse.js"></script>
</body>
</html>
