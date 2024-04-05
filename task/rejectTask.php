<?php
session_start();
include '../php/db.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // First, update the task status to 'rejected'
    $sql = "UPDATE tasks SET status = 'rejected' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Task rejected";

        // After successfully updating the task, insert a notification
        $notifSql = "INSERT INTO notifications (task_id, user_email, status, comments) VALUES (?, ?, 'rejected', 'Job rejected')";
        $notifStmt = $conn->prepare($notifSql);

        // Assuming the user's email is stored in the session or can be retrieved otherwise
        $user_email = $_SESSION['email']; // Replace with actual user email retrieval method

        $notifStmt->bind_param("is", $task_id, $user_email);
        if (!$notifStmt->execute()) {
            $_SESSION['error'] = "Failed to create notification";
        }
        $notifStmt->close();
    } else {
        $_SESSION['error'] = "Failed to reject task";
    }
    $stmt->close();
}

header("Location: ./user_dashboard.php"); // Adjust the redirect as necessary
exit();
?>