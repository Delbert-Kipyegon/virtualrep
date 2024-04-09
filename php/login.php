<?php
session_start();
include 'db.php';
header('Content-Type: application/json');

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['pass']) ? $_POST['pass'] : '';

if (!empty($email) && !empty($password)) {
    // Hash the password with MD5
    $password = md5($password);

    // Use a prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Compare the MD5 hash directly
        if ($password === $row['password']) {
            $_SESSION['unique_id'] = $row['unique_id'];
            $_SESSION['email'] = $row['email'];

            echo json_encode(["success" => true, "message" => "Login successful."]);
        } else {
            echo json_encode(["success" => false, "message" => "Email or Password is incorrect."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Email or Password is incorrect."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
}
?>