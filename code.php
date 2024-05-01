<?php

session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token)
{

    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2;                                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication


    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->Username   = 'syedsaleem.s2993@gmail.com';          //change                  SMTP username dummy 
    $mail->Password   = 'ckpoiiwypnpkxdiy';                      //change                SMTP password dummy


    $mail->SMTPSecure = "tls";                               //Enable implicit TLS encryption
    $mail->Port       = 587;

    $mail->setFrom("syedsaleem.s2993@gmail.com", $name);      //change
    $mail->addAddress($email);

    $mail->isHTML(true);                                     //Set email format to HTML
    $mail->Subject = 'Email Verification from Alphas';       //change

    $email_template = " 
        <h2>You have registered with Alphas</h2>
        <h5>Verify your email address to Login with the below link</h5>
        <br><br>
        <a href='http://localhost/project/verify-email.php?token=$verify_token'>Click me</a>
    ";                                                                              //*****change*****

    $mail->Body    = $email_template;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent'; 
}


if (isset($_POST['register_btn'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email_id'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_passwords'];
    $verify_token = md5(rand());

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['status'] = "Error: Passwords do not match.";
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        
        header("Location: register.php"); // Redirect back to registration page
        exit();
    }


    // Email Exists or not 
    // email column name ,users table name ,phptutorial Database name hai 
    $check_email_query = "SELECT email FROM userdata WHERE email='$email' LIMIT 1 "; //change
    $check_email_query_run = mysqli_query($con, $check_email_query);


    if (mysqli_num_rows($check_email_query_run) > 0) {

        $_SESSION['status'] = "Email already exist";
        header("Location: register.php");
    } else {
        //Register user Data
        $query = "INSERT INTO userdata (name, phone, email, password, verify_token) VALUES ('$name', '$phone', '$email', '$password', '$verify_token')"; //change
        $query_run = mysqli_query($con, $query);

        if ($query_run) {

            sendemail_verify("$name", "$email", "$verify_token");
            $_SESSION['status'] = "Registration Succesful.! Please verify your Email Address.";
            header("Location: login.php");
        } else {
            $_SESSION['status'] = "Registration Failed";
            header("Location: register.php");
        }
    }
}
