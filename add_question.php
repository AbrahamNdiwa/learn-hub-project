<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = htmlspecialchars($_POST['subject_id']);
    $question = htmlspecialchars($_POST['question']);
    $approved = 0;
    if($role == 'admin'){
        $approved = 1;
    }

    $stmt = $conn->prepare("INSERT INTO questions (user_id, subject_id, question, created_at, approved) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("iisi", $user_id, $subject_id, $question, $approved);

    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Error saving subject. Please try again.";
    }
}

$query = "SELECT * FROM subjects";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Post a Question</h2>
        <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <form action="add_question.php" method="POST">
            <div class="mb-3">
                <label for="subject_id" class="form-label">Select Subject</label>
                <select class="form-control" name="subject_id" id="subject_id" required>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['code']; echo " - "; echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Question</label>
                <input type="text" class="form-control" id="question" name="question" required>
            </div>
            <button type="submit" class="btn btn-primary">Post Question</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
