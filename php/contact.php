<?php
session_start();

// Include the file containing the sendEmail function
require_once "./mail.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Check if any required field is empty
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo "Error: Please fill in all required fields.";
    // header("location: ../index.php");
    // alert("Please fill in all required fields.");
    exit;
}

// Call the sendEmail function with the provided parameters
try {
    sendEmail($name, $email, $phone, $subject, $message);
    echo "Email sent successfully!";
} catch (Exception $e) {
    echo "An error occurred while sending the email: " . $e->getMessage();
}
?>
