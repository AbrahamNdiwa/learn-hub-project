<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}
$jcu_number = $_SESSION['jcu_number'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LearnHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./images/favicon.ico">
    <link rel="stylesheet" href="styles/styles.css"/>
</head>
<body>
    <nav class="navbar navbar-light bg-light px-3 ">
        <button class="toggle-btn mt-2" id="sidebarToggle">
            <span class="d-flex justify-content-center align-items-center">☰</span>
        </button>
        <a href="index.php" class="link-underline link-underline-opacity-0 link-underline-opacity-100-hover">
            <h4 class="navbar-brand mx-5">
                <img src="./images/logo.png" width="100px" height="50px" class="object-fit-contain img-fluid rounded float-start" />
            </h4>
        </a>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <?php 
                    $first_letter = strtoupper(substr($jcu_number, 0, 1));
                    $parts = explode('.', $jcu_number);
                    $second_letter = strtoupper(substr($parts[1], 0, 1));
                    echo $first_letter; echo $second_letter;
                ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="d-flex">
        <nav class="sidebar bg-light vh-100 p-3" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link load-page" data-page="dashboard_main.php">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link load-page" data-page="myquestions.php">My Questions</a></li>
                <li class="nav-item"><a href="#" class="nav-link load-page" data-page="myanswers.php">My Answers</a></li>
                <?php 
                if($role == 'admin')
                {
                    ?>
                        <li class="nav-item"><a href="#" class="nav-link load-page" data-page="question_approvals.php">Approve Questions (Admin)</a></li>
                    <?php
                }

                if($role == 'admin')
                {
                    ?>
                        <li class="nav-item"><a href="#" class="nav-link load-page" data-page="answer_approvals.php">Approve Answers (Admin)</a></li>
                    <?php
                }

                if($role == 'admin')
                {
                    ?>
                        <li class="nav-item"><a href="#" class="nav-link load-page" data-page="hidden_questions.php">Hide/Unhide Questions (Admin)</a></li>
                    <?php
                }

                if($role == 'admin')
                {
                    ?>
                        <li class="nav-item"><a href="#" class="nav-link load-page" data-page="subjects.php">Manage Subjects (Admin)</a></li>
                    <?php
                }
                ?>
                <li class="nav-item"><a href="#" class="nav-link load-page" data-page="settings.php">Settings</a></li>
            </ul>
        </nav>

        <div class="container p-4" id="main-content">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#main-content').load('dashboard_main.php');

            $('.load-page').click(function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                $('#main-content').load(page);
                $('#sidebar').toggleClass('hidden');
            });

            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('hidden');
            });
        });
    </script>
</body>
</html>
