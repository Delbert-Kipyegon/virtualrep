<?php
// Start the session and include the database connection
session_start();
include '../php/db.php';  // Adjust the path as per your project structure

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the task ID and comments from the POST data
    $task_id = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_NUMBER_INT);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING);

    // Update the task status to 'completed'
    $updateSql = "UPDATE tasks SET status = 'completed' WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $task_id);

    if (!$updateStmt->execute()) {
        // Handle error - Unable to update the task
        $_SESSION['error_message'] = 'Error updating task status.';
        header("Location: error_page.php"); // Redirect to an error page or similar
        exit();
    }

    // Assuming you're storing the user's email in the session or can retrieve it otherwise
    $user_email = $_SESSION['email']; // Replace with actual user email retrieval method

    // Add a notification
    $notifSql = "INSERT INTO notifications (task_id, user_email, status, comments) VALUES (?, ?, 'completed', ?)";
    $notifStmt = $conn->prepare($notifSql);
    $notifStmt->bind_param("iss", $task_id, $user_email, $comments);

    if (!$notifStmt->execute()) {
        // Handle error - Unable to insert the notification
        $_SESSION['error_message'] = 'Error inserting notification.';
        header("Location: error_page.php"); // Redirect to an error page or similar
        exit();
    }

    // Set a success message and redirect to the dashboard
    $_SESSION['message'] = 'Task submitted successfully and notification sent!';
    header("Location: user_dashboard.php");
    exit();
}