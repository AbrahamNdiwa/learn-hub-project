<?php
include 'db.php';
session_start();

if (!isset($_GET['id'])) {
    die("Invalid question.");
}

$question_id = $_GET['id'];
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

// Fetch question details along with the user's JCU number
$question_query = "SELECT q.*, u.jcu_number FROM questions q 
                   JOIN users u ON q.user_id = u.id
                   WHERE q.id = '$question_id' AND q.approved = 1";
$question_result = mysqli_query($conn, $question_query);
$question = mysqli_fetch_assoc($question_result);

if (!$question) {
    die("Question not found.");
}

$sort = $_GET['sort'] ?? 'recent';
$sort_column = ($sort === 'liked') ? 'like_count DESC' : 'a.created_at DESC';

// Fetch approved answers along with the user's JCU number
$answers_query = "SELECT a.*, u.jcu_number, 
                  (SELECT COUNT(*) FROM likes l WHERE l.answer_id = a.id) AS like_count,
                  (SELECT COUNT(*) FROM likes l WHERE l.answer_id = a.id AND l.user_id = '$user_id') AS user_liked
                  FROM answers a 
                  JOIN users u ON a.user_id = u.id
                  WHERE a.question_id = '$question_id' AND a.approved = 1
                  ORDER BY $sort_column";
$answers_result = mysqli_query($conn, $answers_query);

// Handle answer submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $approved = 0;
    if($role == 'admin'){
        $approved = 1;
    }

    if (!empty($content)) {
        $insert_query = "INSERT INTO answers (question_id, user_id, content, approved) 
                         VALUES ('$question_id', '$user_id', '$content', '$approved')";
        mysqli_query($conn, $insert_query);
        $_SESSION['message'] = "Your answer has been submitted for approval.";
    } else {
        $_SESSION['error'] = "Answer cannot be empty.";
    }
    header("Location: question.php?id=" . $question_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($question['question']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="./images/logo.png" width="100px" height="50px" class="img-fluid rounded float-start" />
        </a>
        <div class="d-flex">
            <a href="index.php" class="btn btn-outline-primary me-2">Home</a>
            <?php if(isset($_SESSION['jcu_number'])): ?>
                <a href="dashboard.php" class="btn btn-outline-success">Dashboard</a>
                <a href="logout.php" class="btn btn-outline-danger ms-2">Logout</a>
            <?php else: ?>
                <a href="login_page.php" class="btn btn-outline-primary">Login / Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2><?= htmlspecialchars($question['question']); ?></h2>
    <p class="text-muted">Asked by: <strong><?= htmlspecialchars($question['jcu_number']); ?></strong></p>

    <!-- Edit & Delete Buttons for Question -->
    <?php if ($user_id && ($user_id == $question['user_id'] || $role === 'admin')): ?>
        <div class="d-flex gap-2 mb-3">
            <?php if ($user_id == $question['user_id']): ?>
                <button class="btn btn-sm btn-outline-primary edit-question"
                        data-id="<?= $question['id'] ?>" 
                        data-content="<?= htmlspecialchars($question['question']) ?>"
                        data-bs-toggle="modal" data-bs-target="#editQuestionModal">
                    Edit
                </button>
            <?php endif; ?>
            <button class="btn btn-sm btn-outline-danger delete-question"
                    data-id="<?= $question['id'] ?>">
                Delete
            </button>
        </div>
    <?php endif; ?>

    <!-- Display Messages -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <h4 class="mt-4">Answers</h4>
    <div class="d-flex justify-content-end align-items-center mb-2">
        <label for="sort fw-bold"><b>Sort by:</b></label>
        <select id="sort" class="form-select w-auto ms-2">
            <option value="recent" <?= ($sort == 'recent') ? 'selected' : '' ?>>Most Recent</option>
            <option value="liked" <?= ($sort == 'liked') ? 'selected' : '' ?>>Most Liked</option>
        </select>
    </div>
    <?php if (mysqli_num_rows($answers_result) > 0): ?>
        <?php while ($answer = mysqli_fetch_assoc($answers_result)): ?>
            <div class="card mb-2">
                <div class="card-body">
                    <p><?= htmlspecialchars($answer['content']); ?></p>
                    <small class="text-muted">Answered by: <strong><?= htmlspecialchars($answer['jcu_number']); ?></strong></small>

                    <div class="d-flex justify-content-between mt-2">
                        <button class="btn btn-sm btn-outline-primary like-btn" 
                                data-id="<?= $answer['id'] ?>" 
                                data-liked="<?= $answer['user_liked'] ?>">
                            👍 <?= ($answer['user_liked'] > 0) ? 'Unlike' : 'Like' ?>
                        </button>
                        <span class="text-muted">Likes: <strong id="like-count-<?= $answer['id'] ?>"><?= $answer['like_count'] ?></strong></span>
                    </div>

                    <!-- Edit & Delete Buttons for Answer -->
                    <?php if ($user_id && ($user_id == $answer['user_id'] || $role === 'admin')): ?>
                        <div class="d-flex gap-2 mt-2">
                            <?php if ($user_id == $answer['user_id']): ?>
                                <button class="btn btn-sm btn-outline-primary edit-answer"
                                        data-id="<?= $answer['id'] ?>" 
                                        data-content="<?= htmlspecialchars($answer['content']) ?>"
                                        data-bs-toggle="modal" data-bs-target="#editAnswerModal">
                                    Edit
                                </button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-outline-danger delete-answer"
                                    data-id="<?= $answer['id'] ?>">
                                Delete
                            </button>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No answers yet.</p>
    <?php endif; ?>

    <!-- Answer Submission Form -->
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="mt-4">
            <h4>Submit Your Answer</h4>
            <form action="question.php?id=<?= $question_id; ?>" method="POST">
                <input type="hidden" name="question_id" value="<?= $question_id; ?>">
                <textarea class="form-control" name="content" rows="4" required></textarea>
                <button type="submit" class="btn btn-primary mt-2">Submit Answer</button>
            </form>
        </div>
    <?php else: ?>
        <p class="mt-4">
            <a href="login_page.php" class="btn btn-warning">Login to Answer</a>
        </p>
    <?php endif; ?>
</div>

    <!-- Edit Question Modal -->
    <div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQuestionModalLabel">Edit Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editQuestionForm">
                        <input type="hidden" id="editQuestionId">
                        <div class="mb-3">
                            <label for="editQuestionContent" class="form-label">Question</label>
                            <textarea class="form-control" id="editQuestionContent" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Answer Modal -->
    <div class="modal fade" id="editAnswerModal" tabindex="-1" aria-labelledby="editAnswerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAnswerModalLabel">Edit Answer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAnswerForm">
                        <input type="hidden" id="editAnswerId">
                        <div class="mb-3">
                            <label for="editAnswerContent" class="form-label">Answer</label>
                            <textarea class="form-control" id="editAnswerContent" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        // Edit Question - GEt Data into Modal
        $('.edit-answer').click(function () {
            var answerId = $(this).data('id');
            var content = $(this).data('content');
            $('#editAnswerId').val(answerId);
            $('#editAnswerContent').val(content);
            $('#editAnswerModal').modal('show');
        });

        $('#editAnswerForm').submit(function (e) {
            e.preventDefault();
            var id = $('#editAnswerId').val();
            var content = $('#editAnswerContent').val();

            $.ajax({
                url: 'update_answer.php',
                type: 'POST',
                data: { id: id, content: content },
                success: function () {
                    location.reload();
                }
            });
        });

        // Edit Question - Set Data into Modal
        $('.edit-question').click(function () {
            var questionId = $(this).data('id');
            var content = $(this).data('content');
            $('#editQuestionId').val(questionId);
            $('#editQuestionContent').val(content);
            $('#editQuestionModal').modal('show');
        });

        // Submit Edit Form
        $('#editQuestionForm').submit(function (e) {
                e.preventDefault();
                var id = $('#editQuestionId').val();
                var content = $('#editQuestionContent').val();

                $.ajax({
                    url: 'update_question.php',
                    type: 'POST',
                    data: { id: id, content: content },
                    success: function () {
                        location.reload();
                    }
                });
            });

        $('.delete-question').click(function () {
            if (confirm("Are you sure you want to delete this question?")) {
                $.post('delete_question.php', { id: $(this).data('id') }, function () {
                    window.location.href = "index.php";
                });
            }
        });

        $('.delete-answer').click(function () {
            if (confirm("Are you sure you want to delete this answer?")) {
                $.post('delete_answer.php', { id: $(this).data('id') }, function () {
                    location.reload();
                });
            }
        });

        // Like/Unlike answer
    $('.like-btn').click(function () {
        var button = $(this);
        var answerId = button.data('id');
        var liked = button.data('liked');

        $.post('like_answer.php', { answer_id: answerId }, function (response) {
            var res = JSON.parse(response);
            if (res.status === 'liked') {
                button.text('👍 Unlike').data('liked', 1);
                $('#like-count-' + answerId).text(parseInt($('#like-count-' + answerId).text()) + 1);
            } else {
                button.text('👍 Like').data('liked', 0);
                $('#like-count-' + answerId).text(parseInt($('#like-count-' + answerId).text()) - 1);
            }
        });
    });

    // Sort answers
    $('#sort').change(function () {
        var sort = $(this).val();
        window.location.href = "question.php?id=<?= $question_id ?>&sort=" + sort;
    });
    });
</script>
</body>
</html>
