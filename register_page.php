<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./images/logo.png" width="100px" height="50px" class="img-fluid rounded float-start" />
            </a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-outline-primary me-2">Home</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class=" my-5">
                                <h4 class="text-center">Register</h4>
                                <form action="register.php" method="POST">
                                    <div class="mb-3">
                                        <label>Full Name</label>
                                        <input type="text" name="fullname" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <button type="submit" name="register" class="btn btn-success w-100">Register</button>
                                </form>

                                <div class="mt-4">
                                    I have already have an account. Login <a href="login_page.php">here</a>!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
