<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$subjects_query = "SELECT * FROM subjects";
$subjects_result = mysqli_query($conn, $subjects_query);
$subjects = [];
while ($subject_row = mysqli_fetch_assoc($subjects_result)) {
    $subjects[$subject_row['id']] = $subject_row['code'] . " - " . $subject_row['name'];
}


// Get user questions
$query = "SELECT * FROM questions WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/styles.css"/>
</head>
<body>
    <div class="container mt-4">
        <h2>My Questions</h2>
        <button class="btn btn-success mb-3 mt-2" id="addQuestionBtn" data-page="add_question">Add A New Question</button>

        <div id="questions-list">
            <?php
            if(mysqli_num_rows($result) > 0)
            {
             while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex flex-row-reverse">
                        <h7>
                            <?php
                            if($row['approved'] == 1)
                            {
                                ?>
                                    <small class="d-inline-block p-1 mb-2 bg-success text-white rounded"> Approved</small>                                <?php
                            }else if($row['approved'] == 0){
                                ?>
                                    <small class="d-inline-block p-1 mb-2 bg-secondary text-white rounded">Pending Approval</small>
                                <?php
                            }else{
                                ?>
                                    <small class="d-inline-block p-1 mb-2 bg-danger text-white rounded text-xs">Declined</small>
                                <?php
                            }
                            ?>
                        </h7>
                        </div>
                        <small ><?= isset($subjects[$row['subject_id']]) ? $subjects[$row['subject_id']] : 'Unknown Subject' ?></small>
                        <h5 class="card-title"><?= htmlspecialchars($row['question']) ?></h5>
                        <button class="btn btn-primary edit-question mt-2" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editQuestionModal"><small>Edit</small></button>
                        <button class="btn btn-outline-danger delete-question mt-2" data-id="<?= $row['id'] ?>"><small>Delete</small></button>
                    </div>
                </div>
            <?php endwhile;
            }else{
                ?> 
                <div class="text-muted">You have not posted a question.</div>
                <?php
            } ?>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQuestionModalLabel">Edit Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editQuestionForm">
                        <input type="hidden" id="editQuestionId">
                        <div class="mb-3">
                            <label for="editSubjectId" class="form-label">Select Subject</label>
                            <select class="form-control" name="editSubjectId" id="editSubjectId" required>
                            <?php foreach ($subjects as $id => $code_name) { ?>
                                <option value="<?= $id ?>"><?= $code_name ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editQuestionContent" class="form-label"><b>Question</b></label>
                            <input type="text" class="form-control" id="editQuestionContent" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            
            $('#addQuestionBtn').click(function(e) {
                e.preventDefault();
                var target = $(this).data('page');
                $('#main-content').load(target + '.php');
            });

            // Open edit modal and insert data into the fields
            $('.edit-question').click(function () {
                var questionId = $(this).data('id');
                $.ajax({
                    url: 'get_question.php',
                    type: 'POST',
                    data: { id: questionId },
                    success: function (response) {
                        var question = JSON.parse(response);
                        $('#editQuestionId').val(question.id);
                        $('#editSubjectId').val(question.subject_id); // Preselect the subject
                        $('#editQuestionContent').val(question.question);
                        $('#editQuestionModal').modal('show');
                    }
                });
            });

            // Submit edit form
            $('#editQuestionForm').submit(function (e) {
                e.preventDefault();
                var id = $('#editQuestionId').val();
                var subject_id = $('#editSubjectId').val();
                var content = $('#editQuestionContent').val();

                $.ajax({
                    url: 'update_question.php',
                    type: 'POST',
                    data: { id: id, subject_id: subject_id, question: content },
                    success: function () {
                        location.reload();
                    }
                });
            });

            // Delete question
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
