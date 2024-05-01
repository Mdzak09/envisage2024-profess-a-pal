<?php
$page_title = "Login";
include('includes/header.php');
// include('includes/navbar.php');
session_start();

if (isset($_SESSION['authenticated'])) {

    $_SESSION['status'] = "You are already phpLogged In";
    header('Location: Profess-a-pal/Faculty/index.html');
    exit(0);
}

?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php
                if (isset($_SESSION['status'])) {
                ?>
                    <div class="alert alert-success">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
                ?>

                <div class="card shadow ">
                    <div class="card-header text-center ">
                        <h5>Login</h5>
                    </div>
                    <div class="card-body">
                        <form action="login_code.php" method="POST">

                            <div class="form-group mb-3">
                                <label for="">Email Address:</label>
                                <input type="text" name="email_id" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password:</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group ">
                                 <button type="submit" name="login_now_btn" class="btn btn-primary" style="padding-left: 30px; padding-right:30px; margin-left:15px">Login</button>  <!--  change -->

                                <a href="password-reset.php" class="float-end">Forgot Your Password?</a>
                            </div>
                            
                        </form>

                        <hr>
                        <h6>
                            Did not recieve Verification Email ?
                            <a href="resend-email-verification.php">Resend</a>

                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>