<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];

$initials = generate_initials($fullname);

// Get user notes
$query = "SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/styles.css"/>
</head>
<body>
    <div class="container mt-4">
        <h2>My Notes</h2>
        <button class="btn btn-success mb-3 mt-2" id="addNoteBtn" data-page="add_note">Add New Note</button>

        <div id="notes-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                        <p><small>Views: <?= $row['views'] ?> | Likes: <?= $row['likes'] ?> | Bookmarks: <?= $row['bookmarks'] ?></small></p>
                        <button class="btn btn-primary edit-note" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editNoteModal">Edit</button>
                        <button class="btn btn-outline-danger delete-note" data-id="<?= $row['id'] ?>">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Edit Note Modal -->
    <div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editNoteForm">
                        <input type="hidden" id="editNoteId">
                        <div class="mb-3">
                            <label for="editNoteTitle" class="form-label"><b>Title</b></label>
                            <input type="text" class="form-control" id="editNoteTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNoteContent" class="form-label font-weight-bold"><b>Content</b></label>
                            <textarea class="form-control" id="editNoteContent" rows="7" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            
            $('#addNoteBtn').click(function(e) {
                e.preventDefault();
                var target = $(this).data('page');
                $('#main-content').load(target + '.php');
            });

            // Open edit modal and insert data into the fields
            $('.edit-note').click(function () {
                var noteId = $(this).data('id');
                $.ajax({
                    url: 'get_note.php',
                    type: 'POST',
                    data: { id: noteId },
                    success: function (response) {
                        var note = JSON.parse(response);
                        $('#editNoteId').val(note.id);
                        $('#editNoteTitle').val(note.title);
                        $('#editNoteContent').val(note.content);
                        $('#editNoteModal').modal('show');
                    }
                });
            });

            // Submit edit form
            $('#editNoteForm').submit(function (e) {
                e.preventDefault();
                var id = $('#editNoteId').val();
                var title = $('#editNoteTitle').val();
                var content = $('#editNoteContent').val();

                $.ajax({
                    url: 'update_note.php',
                    type: 'POST',
                    data: { id: id, title: title, content: content },
                    success: function () {
                        location.reload();
                    }
                });
            });

            // Delete note
            $('.delete-note').click(function () {
                var noteId = $(this).data('id');
                if (confirm("Are you sure you want to delete this note?")) {
                    $.ajax({
                        url: 'delete_note.php',
                        type: 'POST',
                        data: { id: noteId },
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
