<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

// Fetch questions with pending answers
$query = "SELECT DISTINCT q.id, q.question, u.jcu_number FROM answers a 
          JOIN questions q ON a.question_id = q.id
          JOIN users u ON q.user_id = u.id
          WHERE a.approved = 0";
$questions_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Answers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <h4>Answers Pending Approval</h4>
    <?php if (mysqli_num_rows($questions_result) > 0): ?>
    <?php while ($question = mysqli_fetch_assoc($questions_result)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($question['question']); ?></h5>
                <p class="text-muted">Asked by: <strong><?= htmlspecialchars($question['jcu_number']); ?></strong></p>

                <?php
                $question_id = $question['id'];
                $answers_query = "SELECT a.id, a.content, u.jcu_number 
                                  FROM answers a 
                                  JOIN users u ON a.user_id = u.id 
                                  WHERE a.question_id = '$question_id' AND a.approved = 0";
                $answers_result = mysqli_query($conn, $answers_query);
                ?>

                <?php while ($answer = mysqli_fetch_assoc($answers_result)): ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <p><?= htmlspecialchars($answer['content']); ?></p>
                            <small class="text-muted">Answered by: <strong><?= htmlspecialchars($answer['jcu_number']); ?></strong></small>
                            <div class="mt-2">
                                <button class="btn btn-success approve-answer" data-id="<?= $answer['id']; ?>">Approve</button>
                                <button class="btn btn-outline-danger reject-answer" data-id="<?= $answer['id']; ?>">Reject</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile; ?>
    <?php else: ?>
        <div class="text-muted">No answer pending approval.</div>
    <?php endif; ?>

</div>

<script>
    $(document).ready(function () {
        $(".approve-answer").click(function () {
            var answerId = $(this).data("id");
            if (confirm("Approve this answer?")) {
                $.post("approve_answer.php", { id: answerId, value: 1 }, function () {
                    location.reload();
                });
            }
        });

        $(".reject-answer").click(function () {
            var answerId = $(this).data("id");
            if (confirm("Reject this answer?")) {
                $.post("approve_answer.php", { id: answerId, value: 2 }, function () {
                    location.reload();
                });
            }
        });
    });
</script>

</body>
</html>
