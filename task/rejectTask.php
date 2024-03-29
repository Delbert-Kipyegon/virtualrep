<?php
session_start();
include '../php/db.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    $sql = "UPDATE tasks SET status = 'rejected' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Task rejected";
    } else {
        $_SESSION['error'] = "Failed to reject task";
    }
    $stmt->close();
}
header("Location: ./user_dashboard.php"); // Adjust the redirect as necessary
exit();
?>
