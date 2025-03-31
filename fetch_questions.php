<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filtered Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <h4>Filtered Questions</h4>
    <div id="questionsList">
        <?php
        if(isset($_POST['subject_id'])) {
            $subject_id = $_POST['subject_id'];
            $query = "SELECT q.*, 
                      (SELECT COUNT(*) FROM answers a WHERE a.question_id = q.id AND a.approved = 1) AS answer_count
                      FROM questions q
                      WHERE q.approved = 1";
            
            if (!empty($subject_id)) {
                $query .= " AND q.subject_id = '$subject_id'";
            }
            
            $query .= " ORDER BY q.created_at DESC LIMIT 10";
            
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="question.php?id=<?= $row['id']; ?>" class="text-dark text-decoration-none">
                                    <?= htmlspecialchars($row['question']); ?>
                                </a>
                            </h5>
                            <p class="text-muted"><?= $row['answer_count']; ?> Answers</p>
                        </div>
                    </div>
                <?php endwhile;
            } else {
                echo "<p class='text-muted'>No questions available for this subject.</p>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>
