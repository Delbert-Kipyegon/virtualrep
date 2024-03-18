<?php
session_start();
include_once "db.php";
require_once "./mail.php";
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = md5($_POST['pass']);
$cpassword = md5($_POST['cpass']);
$Role = 'user';
$verification_status = '0';

ini_set("display_errors", 1);
error_reporting(E_ALL);

// checking fields are not empty
if (!empty ($fname) && !empty ($lname) && !empty ($email) && !empty ($phone) && !empty ($password) && !empty ($cpassword)) {
    //if email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //checking email already exists
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {

            echo "$email - Already Exists!";
            header("location: ../register.html");
        } else {
            if ($password == $cpassword) {

                $random_id = rand(time(), 10000000);
                $otp = mt_rand(1111, 9999);
                // let's start insert data into table

                $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, phone, password,otp,verification_status, Role)
                    VALUES ({$random_id},'{$fname}','{$lname}','{$email}','{$phone}','{$password}','{$otp}','{$verification_status}','{$Role}')");
                if ($sql2) {
                    $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                    if (mysqli_num_rows($sql3) > 0) {
                        $row = mysqli_fetch_assoc($sql3);
                        $_SESSION['unique_id'] = $row['unique_id'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['otp'] = $row['otp'];


                        //mail function
                        if ($otp) {
                            // $receiver = $email;
                            $name = $fname;
                            $subject = "One Time Password";
                            $message = "Find your OTP Here \nOTP: $otp";
                            // $sender = "From: lemtukeicyprian@gmail.com";

                            try {
                                sendEmail($name, $email, $phone, $subject, $message);
                                echo "Email sent successfully!";
                            } catch (Exception $e) {
                                echo "An error occurred while sending the email: " . $e->getMessage();
                            }

                        }

                        //redirect to verify.php
                        header("Location: ../verify.html");
                    }
                } else {
                    echo "Somethings went wrong! " . mysqli_error($conn);
                    header("location: ../register.html");
                }
            } else {
                echo "Confirm Password Don't Match!";
                header("location: ../register.html");
            }

        }
    } else {
        echo "$email ~ This is not valid Email!";
        header("location: ../register.html");
    }
} else {
    echo "All Inputs Fields are Required!";
    header("location: ../register.html");
}
?>