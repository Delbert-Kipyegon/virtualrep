<?php
session_start();
include '../php/db.php';

// Check if the unique_id is set in the session and the user role is admin
if (!isset($_SESSION['unique_id']) || $_SESSION['Role'] !== 'admin') {
    // Redirect to the login page if the user is not logged in or not an admin
    header("Location: ../login_page.html"); // Adjust the path to your login page
    exit();
}

// Check if the task id is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the task id
    $task_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    // Check if the task id is valid
    if ($task_id !== false && $task_id !== null) {
        // Prepare SQL statement to delete the task
        $sql = "DELETE FROM tasks WHERE id = ?";

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $task_id);
        if ($stmt->execute()) {
            // If deletion is successful
            $_SESSION['success'] = 'Task deleted successfully!';
            // Redirect back to the page where the task was deleted from
            header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back to the previous page
            exit();
        } else {
            // If deletion failed
            $_SESSION['error'] = 'Error deleting task!';
            // Redirect back to the page where the task was deleted from
            header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back to the previous page
            exit();
        }
    } else {
        // If task id is invalid
        $_SESSION['error'] = 'Invalid task id!';
        // Redirect back to the page where the task was deleted from
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back to the previous page
        exit();
    }
} else {
    // If task id is not provided
    $_SESSION['error'] = 'Task id not provided!';
    // Redirect back to the page where the task was deleted from
    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back to the previous page
    exit();
}
?>