<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch answers posted by the logged-in user
$query = "
    SELECT q.id AS question_id, q.question, q.subject_id, a.id AS answer_id, a.content, a.approved 
    FROM answers a
    JOIN questions q ON a.question_id = q.id
    WHERE a.user_id = '$user_id'
    ORDER BY a.created_at DESC";
$result = mysqli_query($conn, $query);

$subjects_query = "SELECT * FROM subjects";
$subjects_result = mysqli_query($conn, $subjects_query);
$subjects = [];
while ($subject_row = mysqli_fetch_assoc($subjects_result)) {
    $subjects[$subject_row['id']] = $subject_row['code'] . " - " . $subject_row['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Answers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/styles.css"/>
</head>
<body>
    <div class="container mt-4">
        <h2>My Answers</h2>

        <div id="answers-list">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <small>
                                <?= isset($subjects[$row['subject_id']]) ? $subjects[$row['subject_id']] : 'Unknown Subject' ?>
                            </small>
                            <h5 class="card-title"><?= htmlspecialchars($row['question']) ?></h5>

                            <div class="answer-section p-3 mt-2 border rounded bg-light">
                                <p><strong>Your Answer:</strong> <?= htmlspecialchars($row['content']) ?></p>
                                
                                <!-- Status Display -->
                                <div>
                                    <?php
                                    if ($row['approved'] == 1) {
                                        echo '<small class="d-inline-block p-1 mb-2 bg-success text-white rounded"> Approved</small>';
                                    } elseif ($row['approved'] == 0) {
                                        echo '<small class="d-inline-block p-1 mb-2 bg-secondary text-white rounded"> Pending Approval</small>';
                                    } else {
                                        echo '<small class="d-inline-block p-1 mb-2 bg-danger text-white rounded"> Rejected</small>';
                                    }
                                    ?>
                                </div>

                                <!-- Edit and Delete Buttons -->
                                <button class="btn btn-primary edit-answer mt-2" data-id="<?= $row['answer_id'] ?>" 
                                    data-content="<?= htmlspecialchars($row['content']) ?>" 
                                    data-bs-toggle="modal" data-bs-target="#editAnswerModal">
                                    Edit
                                </button>
                                <button class="btn btn-outline-danger delete-answer mt-2" data-id="<?= $row['answer_id'] ?>">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-muted">You have not answered any questions.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Answer Modal -->
    <div class="modal fade" id="editAnswerModal" tabindex="-1" aria-labelledby="editAnswerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAnswerModalLabel">Edit Answer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAnswerForm">
                        <input type="hidden" id="editAnswerId">
                        <div class="mb-3">
                            <label for="editAnswerContent" class="form-label"><b>Answer</b></label>
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
            // Open edit modal and insert data
            $('.edit-answer').click(function () {
                var answerId = $(this).data('id');
                var content = $(this).data('content');
                $('#editAnswerId').val(answerId);
                $('#editAnswerContent').val(content);
                $('#editAnswerModal').modal('show');
            });

            // Submit edit form
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

            // Delete answer
            $('.delete-answer').click(function () {
                var answerId = $(this).data('id');
                if (confirm("Are you sure you want to delete this answer?")) {
                    $.ajax({
                        url: 'delete_answer.php',
                        type: 'POST',
                        data: { id: answerId },
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
