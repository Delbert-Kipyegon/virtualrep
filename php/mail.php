<?php

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($name, $email, $phone, $subject, $message)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $mail = new PHPMailer(true);

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

    // Replace with the new SMTP server details
    $mail->Host = "mail.virtualrep.online";
    $mail->Port = 587; // Use port 465 for SSL, 587 for STARTTLS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use ENCRYPTION_SMTPS for port 465

    $mail->Username = "mail@virtualrep.online";
    $mail->Password = "i3m0ekr)S8j?";

    $myemail = "mail@virtualrep.online";
    $myname = "VirtualRep";

    $mail->setFrom($myemail, $myname);
    $mail->addAddress($email, $name);

    $mail->Subject = $subject;
    $mail->Body = $message;

    try {
        $mail->send();
        // Uncomment for debugging
        // echo "Email sent";
        return true;
    } catch (Exception $e) {
        // Uncomment for debugging
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

// Example usage:
// sendEmail($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['subject'], $_POST['message']);
?>