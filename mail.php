<?php

// require 'PHPMailerAutoload.php'; // Make sure to include the PHPMailer autoload file

// $mail = new PHPMailer;


// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = true;
// $mail->Username = 'lemtukeicyprian@gmail.com'; // Your full Gmail address
// $mail->Password = 'tkhrioxdmpklchwh'; // The app-specific password you generated
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;

// $sender_name = "My Website";
// $sender_email = "lemtukeicyprian@gmail.com";
// $recipient_email = "delbertkiki@gmail.com";
// $subject = "Test Email";
// $body = "This is a test email";
// ini_set('smtp_port', '587');


// if (mail($recipient_email, $subject, $body, "From: $sender_name <$sender_email>")) {
//     echo "Email sent successfully";
// } else {
//     echo "Email could not be sent";
// }
   





$to = "delbertkiki@gmail.com";
$subject = "Test email";
$message = "This is a test email.";
$headers = "From: lemtukeicyprian@gmail.com\r\n";
$headers .= "Reply-To: lemtukeicyprian@gmail.com\r\n";
$headers .= "Return-Path: lemtukeicyprian@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";

// Set the SMTP configuration
ini_set("SMTP","smtp.gmail.com");
ini_set("smtp_port","587");
ini_set("sendmail_from","lemtukeicyprian@gmail.com");
ini_set("auth_username","lemtukeicyprian@gmail.com");
ini_set("auth_password","tkhrioxdmpklchwh");
ini_set("force_sender","lemtukeicyprian@gmail.com");

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Failed to send email.";
}




//
// require 'vendor/autoload.php';

// function sendEmail($to, $subject, $message) {
//     // SMTP server configuration
//     $smtpHost = 'smtp.gmail.com';
//     $smtpPort = 587; // TLS encryption port
//     $smtpUsername = 'lemtukeicyprian@gmail.com'; // Your Gmail address
//     $smtpPassword = 'tkhrioxdmpklchwh'; // Your Gmail password
    
//     // Email headers
//     $headers = "From: $smtpUsername\r\n";
//     $headers .= "Reply-To: $smtpUsername\r\n";
//     $headers .= "X-Mailer: PHP/" . phpversion();
    
//     // SMTP configuration
//     $smtpConfig = [
//         'ssl' => [
//             'verify_peer' => false,
//             'verify_peer_name' => false,
//             'allow_self_signed' => true
//         ],
//         'auth' => true,
//         'smtp' => [
//             'timeout' => 30,
//             'host' => $smtpHost,
//             'port' => $smtpPort,
//             'username' => $smtpUsername,
//             'password' => $smtpPassword,
//             'tls' => true
//         ]
//     ];

//     // Create SMTP transport
//     $transport = new \Zend\Mail\Transport\Smtp(new \Zend\Mail\Transport\SmtpOptions($smtpConfig));

//     try {
//         // Create email
//         $email = new \Zend\Mail\Message();
//         $email->setFrom($smtpUsername)
//             ->addTo($to)
//             ->setSubject($subject)
//             ->setBody($message);
        
//         // Send email
//         $transport->send($email);
        
//         return true; // Email sent successfully
//     } catch (\Exception $e) {
//         // Handle errors
//         echo 'Email could not be sent. Error: ' . $e->getMessage();
//         return false; // Email sending failed
//     }
// }

// // Example usage
// $to = 'delbertkip@gmail.com';
// $subject = 'Test Subject';
// $message = 'This is a test email message.';
// if (sendEmail($to, $subject, $message)) {
//     echo 'Email sent successfully.';
// } else {
//     echo 'Failed to send email.';
// }


// require 'PHPMailerAutoload.php';

// $mail = new PHPMailer;

// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = true;
// $mail->Username = 'lemtukeicyprian@gmail.com'; // Your Gmail address
// $mail->Password = 'tkhrioxdmpklchwh'; // Your Gmail password
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;

// $mail->setFrom('lemtukeicyprian@gmail.com', 'My Website');
// $mail->addAddress('delbertkiki@gmail.com', 'Delbert Kiki');
// $mail->addReplyTo('info@example.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');

// $mail->isHTML(true);
// $mail->Subject = 'Test Email';
// $mail->Body    = 'This is a test email message.';
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients.';

// if(!$mail->send()) {
//     echo 'Message could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message has been sent';
// }
