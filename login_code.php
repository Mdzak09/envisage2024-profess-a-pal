<?php
include('dbcon.php');
session_start();

if (isset($_POST['login_now_btn'])) {

    if (!empty(trim($_POST['email_id']))  && !empty(trim($_POST['password']))) {

        $email = mysqli_real_escape_string($con,$_POST['email_id']);            //user entered
        $password = mysqli_real_escape_string($con,$_POST['password']);

        $login_query = "SELECT * FROM userdata WHERE email='$email' AND password='$password' LIMIT 1";  //in database
        $login_query_run = mysqli_query($con,$login_query);

        if(mysqli_num_rows($login_query_run) > 0){

            $row = mysqli_fetch_array($login_query_run);
            // echo $row['verify_status'];
            if( $row['verify_status'] == "1"){

                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username' => $row['Name'],
                    'phone' => $row['Phone'],
                    'email' => $row['Email']
                ];

                $_SESSION['status'] = "Logged In Successfully";
                header("Location:Profess-a-pal/Faculty/index.html");
                exit(0);
            }
            else{

                $_SESSION['status'] = "Please Verify your Email address to Login.";
                header("Location: login.php");
                exit(0);
            }
            
        }
        else{

            $_SESSION['status'] = "Invalid Email or Password";
            header("Location: login.php");
            exit(0);

        }


    } else {

        $_SESSION['status'] = "All fields are Mandatory";
        header("Location: login.php");
        exit(0);

    }
}
?>