<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

// Fetch subjects
$subjects_query = "SELECT * FROM subjects";
$subjects_result = mysqli_query($conn, $subjects_query);
$subjects = [];
while ($subject_row = mysqli_fetch_assoc($subjects_result)) {
    $subjects[$subject_row['id']] = $subject_row['code'] . " - " . $subject_row['name'];
}

// Fetch 10 most recent approved questions
$questions_query = "SELECT q.*, 
                   (SELECT COUNT(*) FROM answers a WHERE a.question_id = q.id AND a.approved = 1) AS answer_count
                   FROM questions q 
                   WHERE q.approved = 1 
                   ORDER BY q.created_at DESC 
                   LIMIT 10";
$questions_result = mysqli_query($conn, $questions_query);
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

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./images/logo.png" width="100px" height="50px" class="img-fluid rounded float-start" />
            </a>
            <div class="d-flex">
                <?php if(isset($_SESSION['jcu_number'])): ?>
                    <div class="d-flex gap-3 align-items-center">
                        <a href="dashboard.php" class="btn btn-outline-success">Dashboard</a>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['jcu_number']; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login_page.php" class="btn btn-outline-primary me-2">Login / Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h4 class="mb-3">Sort by Subject</h4>
        <select id="subjectFilter" class="form-select w-50">
            <option value="">All Subjects</option>
            <?php foreach ($subjects as $id => $subject): ?>
                <option value="<?= $id ?>"><?= htmlspecialchars($subject) ?></option>
            <?php endforeach; ?>
        </select>

        <h4 class="mt-4">Recent Questions</h4>
        <div id="questionsList">
            <?php if (mysqli_num_rows($questions_result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($questions_result)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <small class="text-muted"><?= isset($subjects[$row['subject_id']]) ? $subjects[$row['subject_id']] : 'Unknown Subject' ?></small>
                            <h5 class="card-title">
                                <a href="question.php?id=<?= $row['id']; ?>" class="text-dark text-decoration-none">
                                    <?= htmlspecialchars($row['question']); ?>
                                </a>
                            </h5>
                            <p class="text-muted"><?= $row['answer_count']; ?> Answers</p>

                            <!-- Edit/Delete Buttons -->
                            <?php if ($user_id && ($user_id == $row['user_id'] || $role == 'admin')): ?>
                                <div class="d-flex gap-2">
                                    <?php if ($user_id == $row['user_id']): ?>
                                        <button class="btn btn-sm btn-outline-primary edit-question" 
                                                data-id="<?= $row['id'] ?>" 
                                                data-content="<?= htmlspecialchars($row['question']) ?>"
                                                data-bs-toggle="modal" data-bs-target="#editQuestionModal">
                                            Edit
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-outline-danger delete-question" 
                                            data-id="<?= $row['id'] ?>">
                                        Delete
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No questions available.</p>
            <?php endif; ?>
        </div>
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

    <script>
        $(document).ready(function () {
            $('#subjectFilter').change(function () {
                var subjectId = $(this).val();
                $.ajax({
                    url: 'fetch_questions.php',
                    type: 'POST',
                    data: { subject_id: subjectId },
                    success: function (data) {
                        $('#questionsList').html(data);
                    }
                });
            });
            
            // Edit Question - Load Data into Modal
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

            // Delete Question
            $('.delete-question').click(function () {
                var questionId = $(this).data('id');
                if (confirm("Are you sure you want to delete this question?")) {
                    $.ajax({
                        url: 'delete_question.php',
                        type: 'POST',
                        data: { id: questionId },
                        success: function () {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
