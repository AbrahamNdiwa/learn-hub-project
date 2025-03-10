<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "learnhub";
$port = 3360;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prevent SQL injection
function clean_user_data($data) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, trim($data)));
}

function generate_initials($str) {
    $ret = '';
    foreach (explode(' ', $str) as $word)
        $ret .= strtoupper($word[0]);
    return $ret;
}

// Log user activity
function logActivity($user_id, $action, $note_id = null) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO activity (user_id, action, note_id) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isi", $user_id, $action, $note_id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
}


?>