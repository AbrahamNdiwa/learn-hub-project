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
$query = "SELECT * FROM questions WHERE approved = 0";
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
        <div class="mb-4">
            <h4>Questions Pending Approval</h4>
        </div>

        <div id="questions-list">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
                            <button class="btn btn-success approve-question mt-2" data-value="1" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editQuestionModal"><small>Approve</small></button>
                            <button class="btn btn-outline-danger reject-question mt-2" data-value="2" data-id="<?= $row['id'] ?>"><small>Reject</small></button>
                        </div>
                    </div>
                <?php endwhile; ?>

                <?php else: ?>
                <div class=" mt-4">
                    <h6 class="text-muted">No questions pending approval</h6>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.approve-question').click(function () {
                var questionId = $(this).data('id');
                var value = $(this).data('value');
                    $.ajax({
                        url: 'approve_question.php',
                        type: 'POST',
                        data: { id: questionId, value: value },
                        success: function () {
                            location.reload();
                        }
                    });
            });

            $('.reject-question').click(function () {
                var questionId = $(this).data('id');
                var value = $(this).data('value');
                    $.ajax({
                        url: 'approve_question.php',
                        type: 'POST',
                        data: { id: questionId, value: value },
                        success: function () {
                            location.reload();
                        }
                    });
            });
        });
    </script>
</body>
</html>
