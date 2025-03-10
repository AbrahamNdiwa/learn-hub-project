<?php
include 'db.php';
session_start();

// Get recent notes
$recentNotesQuery = "SELECT * FROM notes ORDER BY created_at DESC LIMIT 3";
$recentNotes = mysqli_query($conn, $recentNotesQuery);

// Get popular notes based on bookmarks/likes
$popularNotesQuery = "SELECT * FROM notes ORDER BY bookmarks DESC, likes DESC LIMIT 3";
$popularNotes = mysqli_query($conn, $popularNotesQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./images/favicon.ico">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./images/logo.png" width="100px" height="50px" class="img-fluid rounded float-start" />
            </a>
            <div class="d-flex">
                <?php if(isset($_SESSION['fullname'])): ?>
                    <?php $initials = generate_initials($_SESSION['fullname']); ?>
                    <div class="d-flex gap-3 align-items-center">
                    <div>
                        <a href="dashboard.php" class="btn btn-outline-success">Dashboard</a>
                        <!-- <a class="dropdown-item" href="dashboard.php">Dashboard</a> -->
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $initials; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <!-- <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li> -->
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login_page.php" class="btn btn-outline-primary me-2">Login / Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="text-center">
            <input type="text" id="search" class="form-control rounded-pill w-50 mx-auto" placeholder="Search notes...">
        </div>
        <div class="mt-3 d-flex justify-content-center gap-2">
            <button class="badge bg-secondary p-2 category-filter">Math</button>
            <button class="badge bg-secondary p-2 category-filter">Physics</button>
            <button class="badge bg-secondary p-2 category-filter">Chemistry</button>
            <button class="badge bg-secondary p-2 category-filter">Biology</button>
        </div>

        <div id="searchResults" class="mt-3"></div>
        <div id="main">
            <h4 class="mt-4">Recent Notes</h4>
            <div class="row">
                <?php while($note = mysqli_fetch_assoc($recentNotes)): ?>
                    <div class="col-md-4">
                        <div class="card p-3">
                            <h5><a href="note.php?id=<?php echo $note['id']; ?>"><?php echo htmlspecialchars($note['title']); ?></a></h5>
                            <p><?php echo htmlspecialchars(substr($note['content'], 0, 75)); ?>...</p>
                            <p><small>Views: <?= $note['views'] ?> | Likes: <?= $note['likes'] ?> | Bookmarks: <?= $note['bookmarks'] ?></small></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <h4 class="mt-4">Popular Notes</h4>
            <div class="row">
                <?php while($note = mysqli_fetch_assoc($popularNotes)): ?>
                    <div class="col-md-4">
                        <div class="card p-3">
                            <h5><a href="note.php?id=<?php echo $note['id']; ?>"><?php echo htmlspecialchars($note['title']); ?></a></h5>
                            <p><?php echo htmlspecialchars(substr($note['content'], 0, 75)); ?>...</p>
                            <p><small>Views: <?= $note['views'] ?> | Likes: <?= $note['likes'] ?> | Bookmarks: <?= $note['bookmarks'] ?></small></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <script src="script/script.js"></script>
</body>
</html>