<?php
session_start();
include('dbcon.php');

    if(isset($_GET['token'])){

        $token = $_GET['token'];
        $verify_query = "SELECT verify_token,verify_status  FROM userdata WHERE verify_token='$token' LIMIT 1"; //change
        $verify_query_run = mysqli_query($con,$verify_query);

        if(mysqli_num_rows($verify_query_run) > 0){
            $row = mysqli_fetch_array($verify_query_run);
            // echo $row['verify_token'];

            if($row['verify_status']=="0"){

                $clicked_token = $row['verify_token'];
                $update_query = "UPDATE userdata SET verify_status = '1' Where verify_token = '$clicked_token' LIMIT 1"; //change
                $update_query_run = mysqli_query($con,$update_query);

                if($update_query_run){
                    $_SESSION['status'] = "Your Account has been verified Successfully.!"; //change
                     header("Location: login.php");
                    exit(0);
                }
                else{
                    $_SESSION['status'] = "Verification Failed.!";  //change
                    header("Location: login.php");
                    exit(0);
                }
            }
            else{
                $_SESSION['status'] = "Email Already Verified. Please Login";   //change
                header("Location: login.php");
                exit(0);
            }
        }
        else{
        
            $_SESSION['status'] = "This Token does not Exists"; //change
            header("Location: login.php");
        }
    }
    else{
        
        $_SESSION['status'] = "Not Allowed";    //change
        header("Location: login.php");
    }
    
?>