<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $jcu_number = clean_user_data($_POST['jcu_number']);
    $password = password_hash(clean_user_data($_POST['password']), PASSWORD_BCRYPT);
    $role = 'student';
    echo $jcu_number;
    // Check if jcunumber already exists
    $check_query = "SELECT id FROM users WHERE jcu_number = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $jcu_number);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>
                alert('JCU Number already registered. Please use another JCU number.');
                window.location.href = 'login_page.php';
              </script>";
        exit();
    }

    // Insert user if email is not taken
    $sql = "INSERT INTO users (jcu_number, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $jcu_number, $password, $role);

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
