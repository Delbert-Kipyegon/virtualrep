<?php
session_start();
include 'db.php';
// Include the file containing the sendEmail function
// require_once "./mail.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';
$unique_id = $_SESSION['unique_id'];

// Check if any required field is empty
if (empty ($name) || empty ($email) || empty ($subject) || empty ($message)) {
    echo "Error: Please fill in all required fields.";
    // header("location: ../index.php");
    // alert("Please fill in all required fields.");
    exit;
}


require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($name, $email, $phone, $subject, $message)
{
    try {
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

    // Redirect based on unique_id
    if (empty ($unique_id)) {

        header("location: ../homepage.php");
    } else {
        header("location: ../register.html");
    }
    exit;
}
// Example usage:
sendEmail($name, $email, $phone, $subject, $message);
