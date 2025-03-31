<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Fetch hidden questions
$hidden_questions_query = "SELECT q.*, 
                   (SELECT COUNT(*) FROM answers a WHERE a.question_id = q.id AND a.approved = 1) AS answer_count
                   FROM questions q 
                   WHERE q.hidden = 1 
                   ORDER BY q.created_at DESC";
$hidden_questions_result = mysqli_query($conn, $hidden_questions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hidden Questions - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div class="container mt-4">
        <h2>Hidden Questions</h2>
        <div id="hiddenQuestionsList">
            <?php if (mysqli_num_rows($hidden_questions_result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($hidden_questions_result)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['question']); ?></h5>
                            <p class="text-muted"><?= $row['answer_count']; ?> Answers</p>
                            <button class="btn btn-sm btn-outline-warning unhide-question" data-id="<?= $row['id'] ?>">
                                Unhide
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No hidden questions.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.unhide-question').click(function () {
                var questionId = $(this).data('id');
                
                $.ajax({
                    url: 'toggle_question_visibility.php',
                    type: 'POST',
                    data: { id: questionId, hidden: 1 }, 
                    success: function (response) {
                        if (response === "Success") {
                            location.reload();
                        } else {
                            alert("An error occurred");
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>
