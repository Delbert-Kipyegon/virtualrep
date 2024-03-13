<?php

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($name, $email, $phone, $subject, $message) {
    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    


    $mail = new PHPMailer(true);

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = "lemtukeicyprian@gmail.com";
    $mail->Password = "tkhrioxdmpklchwh";

    $myemail = "lemtukeicyprian@gmail.com";
    $myname = "Cyprian";

    $mail->setFrom($myemail, $myname);

    $mail->addAddress($email, $name);

    $mail->Subject = $subject;
    $mail->Body = $message;

    try {
        $mail->send();
        echo "Email sent";
        header("location: ../index.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Example usage:
// sendEmail($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['subject'], $_POST['message']);
?>
