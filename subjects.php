<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Get user notes
$query = "SELECT * FROM subjects";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/styles.css"/>
</head>
<body>
    <div class="container mt-4">
        <h2>Subjects</h2>
        <button class="btn btn-success mb-3 mt-2" id="addSubjectBtn" data-page="add_subject">Add New Subject</button>

        <div id="notes-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['code']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($row['name'])) ?></p>
                        <button class="btn btn-primary edit-subject" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editSubjectModal">Edit</button>
                        <button class="btn btn-outline-danger delete-subject" data-id="<?= $row['id'] ?>">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Edit Note Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSubjectForm">
                        <input type="hidden" id="editSubjectId">
                        <div class="mb-3">
                            <label for="editSubjectCode" class="form-label"><b>Subject Code</b></label>
                            <input type="text" class="form-control" id="editSubjectCode" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSubjectName" class="form-label"><b>Subject Title</b></label>
                            <input type="text" class="form-control" id="editSubjectName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            
            $('#addSubjectBtn').click(function(e) {
                e.preventDefault();
                var target = $(this).data('page');
                $('#main-content').load(target + '.php');
            });

            // Open edit modal and insert data into the fields
            $('.edit-subject').click(function () {
                var subjectId = $(this).data('id');
                $.ajax({
                    url: 'get_subject.php',
                    type: 'POST',
                    data: { id: subjectId },
                    success: function (response) {
                        var subject = JSON.parse(response);
                        $('#editSubjectId').val(subject.id);
                        $('#editSubjectName').val(subject.name);
                        $('#editSubjectCode').val(subject.code);
                        $('#editSubjectModal').modal('show');
                    }
                });
            });

            // Submit edit form
            $('#editSubjectForm').submit(function (e) {
                e.preventDefault();
                var id = $('#editSubjectId').val();
                var name = $('#editSubjectName').val();
                var code = $('#editSubjectCode').val();

                $.ajax({
                    url: 'update_subject.php',
                    type: 'POST',
                    data: { id: id, name: name, code: code },
                    success: function () {
                        location.reload();
                    }
                });
            });

            // Delete Subject
            $('.delete-subject').click(function () {
                var subjectId = $(this).data('id');
                if (confirm("Are you sure you want to delete this subject?")) {
                    $.ajax({
                        url: 'delete_subject.php',
                        type: 'POST',
                        data: { id: subjectId },
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
