<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function resend_email_verification($name, $email, $verify_token)
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
    $mail->Subject = 'Resend - Email Verification from Alphas';       //change

    $email_template = " 
        <h2>You have registered with Alphas</h2>
        <h5>Verify your email address to Login with the below link</h5>
        <br><br>
        <a href='http://localhost/project/verify-email.php?token=$verify_token'>Click me</a>
    ";                                                                              //*****change*****

    $mail->Body    = $email_template;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
}


if (isset($_POST['resend_email_verify_btn'])) {

    if (!empty(trim($_POST['email']))) {

        $email = mysqli_real_escape_string($con, $_POST['email']);

        $checkemail_query = "SELECT * FROM userdata WHERE email='$email' LIMIT 1";   //change
        $checkemail_query_run = mysqli_query($con, $checkemail_query);

        if (mysqli_num_rows($checkemail_query_run) > 0) {

            $row = mysqli_fetch_array($checkemail_query_run);
            if ($row['verify_status'] == "0") {

                $name = $row['Name'];
                $reg_email = $row['Email'];
                $verify_token = $row['verify_token'];
                

                

                resend_email_verification($name, $reg_email, $verify_token);

                $_SESSION['status'] = "Verification link has been sent to your Email Adress.!";  //change


                header("Location: login.php");
                exit(0);
            } else {

                $_SESSION['status'] = "Email already verified.";
                header("Location: resend-email-verification.php");
                exit(0);
            }
        } else {

            $_SESSION['status'] = "Given Email is not Registered. Please Register the Email first"; //change
            header("Location: register.php");
            exit(0);
        }
    } else {

        $_SESSION['status'] = "Please enter the Email Id";
        header("Location: resend_email_verification.php");
        exit(0);
    }
}

?>

<h5><?= $row['name']; ?></h5>

