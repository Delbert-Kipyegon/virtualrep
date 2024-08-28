<?php
session_start();
include '../php/db.php';
require_once "../php/mail.php"; // Include the mail script

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // First, update the task status to 'rejected'
    $sql = "UPDATE tasks SET status = 'rejected' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Task rejected successfully";

        // Insert a notification
        $notifSql = "INSERT INTO notifications (task_id, user_email, status, comments) VALUES (?, ?, 'rejected', 'Job rejected')";
        $notifStmt = $conn->prepare($notifSql);

        $user_email = $_SESSION['email']; // User's email stored in the session
        $notifStmt->bind_param("is", $task_id, $user_email);

        if (!$notifStmt->execute()) {
            $_SESSION['error'] = "Failed to create notification";
        }
        $notifStmt->close();

        // Send email notification
        $admin_email = "users@virtualrep.online"; // Admin's email
        $fname = $_SESSION['fname']; // Assuming user's first name is stored in the session
        $phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; // Assuming user's phone is stored in the session
        $subject = "Task ID $task_id - Rejection Notification";

        $message = "Dear Admin,\n\n" .
            "This is to inform you that the task with ID $task_id has been rejected by the user.\n" .
            "User Email: " . $_SESSION['email'] . "\n" .
            "Please log in to the admin dashboard for more details.\n\n" .
            "Best regards,\n" .
            "Virtual Rep";

        sendEmail($fname, $admin_email, $phone, $subject, $message);

    } else {
        $_SESSION['error'] = "Failed to reject task";
    }

    $stmt->close();
}

header("Location: ./user_dashboard.php"); // Adjust the redirect as necessary
exit();
