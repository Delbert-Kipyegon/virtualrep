<?php

session_start();

include_once "db.php";
require_once "./mail.php";

header('Content-Type: application/json');

$fname = $_POST['fname'] ?? '';
$lname = $_POST['lname'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = md5($_POST['pass'] ?? '');
$cpassword = md5($_POST['cpass'] ?? '');
$role = 'user';
$verification_status = '0';

$response = ['success' => false, 'message' => ''];

if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($password) || empty($cpassword)) {
    $response['message'] = "All input fields are required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = "$email is not a valid email address.";
} elseif ($password !== $cpassword) {
    $response['message'] = "Passwords do not match.";
} else {

    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        $response['message'] = "A user with the email $email already exists.";
    } else {

        $random_id = rand(time(), 10000000);
        $otp = mt_rand(1111, 9999);

        // Set session variables
        $_SESSION['unique_id'] = $random_id;
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = $otp;

        $email_sent = sendEmail($fname, $email, $phone, "One Time Password", "Find your OTP Here \nOTP: $otp");
        if (!$email_sent) {
            $response = ['success' => false, 'message' => "Failed to send email. Use a valid email. Registration failed."];
        } else {

            $insertStmt = $conn->prepare("INSERT INTO users (unique_id, fname, lname, email, phone, password, otp, verification_status, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("isssssisi", $random_id, $fname, $lname, $email, $phone, $password, $otp, $verification_status, $role);

            if ($insertStmt->execute()) {
                $response = ['success' => true, 'message' => "Registration successful. Email sent successfully."];

            } else {
                // Something went wrong during registration
                $response = ['success' => false, 'message' => "Something went wrong during registration."];
            }
        }
    }
}

echo json_encode($response);


// // Set session variables
// $_SESSION['unique_id'] = $random_id;
// $_SESSION['email'] = $email;
// $_SESSION['otp'] = $otp;

// // Attempt to send email
// if (sendEmail($fname, $email, $phone, "One Time Password", "Find your OTP Here \nOTP: $otp")) {
//     // Email sent successfully
//     $response = ['success' => true, 'message' => "Registration successful. Email sent successfully."];
// } else {
//     // Failed to send email
//     $response = ['success' => false, 'message' => "Failed to send email. Registration successful."];

// }




