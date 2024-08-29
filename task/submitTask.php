<?php
// Start the session and include the database connection
session_start();
include '../php/db.php';  // Adjust the path as per your project structure
require_once "../php/mail.php"; // Include the mail script

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

    // Retrieve user's email from session
    $user_email = $_SESSION['email']; // User's email stored in the session

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

    // Send email notification to admin
    $admin_email = "users@virtualrep.online"; // Admin's email address
    $fname = isset($_SESSION['fname']) ? $_SESSION['fname'] : ''; // Assuming user's first name is stored in the session
    $phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; // Assuming user's phone is stored in the session
    $subject = "Task ID $task_id - Completion Notification";

    $message = "Dear Admin,\n\n" .
        "This is to inform you that the task with ID $task_id has been completed by the user.\n" .
        "User Email: $user_email\n" .
        "Comments: $comments\n\n" .
        "Please log in to the admin dashboard for more details.\n\n" .
        "Best regards,\n" .
        "Virtual Rep";

    sendEmail($fname, $admin_email, $phone, $subject, $message);

    // Set a success message and redirect to the dashboard
    $_SESSION['message'] = 'Task submitted successfully, notification sent, and email sent to admin!';
    header("Location: user_dashboard.php");
    exit();
}