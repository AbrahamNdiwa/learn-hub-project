<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $fullname = clean_user_data($_POST['fullname']);
    $email = clean_user_data($_POST['email']);
    $password = password_hash(clean_user_data($_POST['password']), PASSWORD_BCRYPT);

    // Check if email already exists
    $check_query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>
                alert('Email already registered. Please use another email.');
                window.location.href = 'login_page.php';
              </script>";
        exit();
    }

    // Insert user if email is not taken
    $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullname, $email, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Successfully registered! Click OK to proceed to login.');
                window.location.href = 'login_page.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
