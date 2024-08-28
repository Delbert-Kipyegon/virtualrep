<?php
session_start();
include '../php/db.php';
require_once "../php/mail.php"; // Include the mail script

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // First, update the task status to 'accepted'
    $sql = "UPDATE tasks SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Task accepted successfully";

        // Insert a notification
        $notifSql = "INSERT INTO notifications (task_id, user_email, status, comments) VALUES (?, ?, 'accepted', 'Job accepted')";
        $notifStmt = $conn->prepare($notifSql);

        $users_email = "users@virtualrep.online"; // Admin's email
        $notifStmt->bind_param("is", $task_id, $users_email);

        if (!$notifStmt->execute()) {
            $_SESSION['error'] = "Failed to create notification";
        }
        $notifStmt->close();

        // Send email notification
        $fname = $_SESSION['fname']; // Assuming user's first name is stored in the session
        $phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; // Assuming user's phone is stored in the session
        $subject = "Task ID $task_id - Acceptance Confirmation";

        $message = "Dear Admin,\n\n" .
            "This is to inform you that the task with ID $task_id has been successfully accepted by the user.\n" .
            "User Email: " . $_SESSION['email'] . "\n" .
            "Please log in to the admin dashboard for more details.\n\n" .
            "Best regards,\n" .
            "Virtual Rep";
        sendEmail($fname, $users_email, $phone, $subject, $message);

    } else {
        $_SESSION['error'] = "Failed to accept task";
    }

    $stmt->close();
}

header("Location: ./user_dashboard.php"); // Adjust the redirect as necessary
exit();