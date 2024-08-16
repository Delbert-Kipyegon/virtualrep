<?php
session_start();
include 'db.php';

// Include the file containing the sendEmail function if required
// require_once "./mail.php";

// Error reporting and display settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve POST data and session information
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';
$unique_id = $_SESSION['unique_id'] ?? '';

// Check if any required field is empty
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo "Error: Please fill in all required fields.";
    exit;
}

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($name, $email, $phone, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.virtualrep.online";
        $mail->Port = 587; // Use port 465 for SSL, 587 for STARTTLS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use ENCRYPTION_SMTPS for port 465

        $mail->Username = "mail@virtualrep.online";
        $mail->Password = "i3m0ekr)S8j?";

        $myemail = "mail@virtualrep.online";
        $myname = "VirtualRep"; // Replace with your name or your company name

        $mail->setFrom($email, $name);
        $mail->addAddress($myemail, $myname);

        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit;
    }
}

// Call the function to send email
sendEmail($name, $email, $phone, $subject, $message);

// Redirect based on unique_id
if (empty($unique_id)) {
    header("Location: ../homepage.php");
} else {
    header("Location: ../register.html");
}
exit;
?>