<?php
session_start();
include '../php/db.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    $sql = "UPDATE tasks SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Task accepted successfully";
    } else {
        $_SESSION['error'] = "Failed to accept task";
    }
    $stmt->close();
}
header("Location: ./user_dashboard.php"); // Adjust the redirect as necessary
exit();
?>