<?php
include 'db.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id) {
    echo "<p>Please log in to view your bookmarked notes.</p>";
    exit();
}

$questions_query = "SELECT * FROM questions WHERE user_id = '$user_id' AND approved = 1";
$questions_result = mysqli_query($conn, $questions_query);
$questions_count = mysqli_num_rows($questions_result);

$answers_query = "SELECT * FROM answers WHERE user_id = '$user_id' AND approved = 1";
$answers_result = mysqli_query($conn, $answers_query);
$answers_count = mysqli_num_rows($answers_result);

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
        <small class="mt-3 mb-10">Welcome <?php 
        $first_letter = strtoupper(substr($_SESSION['jcu_number'], 0, 1));
        $parts = explode('.', $_SESSION['jcu_number']);
        $second_letter = strtoupper(substr($parts[1], 0, 1));
        echo $first_letter; echo $second_letter;
        ?>,
        
    </small>
        <div class="row mt-2 mb-5">
            <div class="col-md-4 mb-2">
                <div class="card p-3">
                    <h5>My Approved Questions</h5>
                    <p><?php echo $questions_count; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card p-3">
                    <h5>My Approved Answers</h5>
                    <p><?php echo $answers_count; ?></p>
                </div>
            </div>
            <!-- <div class="col-md-4 mb-2">
                <div class="card p-3">
                    <h5>Total Bookmarks</h5>
                    <p><?php echo $total_bookmarks; ?></p>
                </div>
            </div> -->
        </div>
        <a href="#" class="btn btn-primary load-page" data-page="add_question.php">Post New Question</a>
        <a href="index.php" class="btn btn-secondary">Browse Questions</a>
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
