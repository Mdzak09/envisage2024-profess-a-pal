<?php
$page_title = "Register";
include('includes/header.php');
// include('includes/navbar.php');
session_start();

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
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h5>Registration</h5>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Name:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Phone Number: </label>
                                <input type="number" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Email Address:</label>
                                <input type="text" name="email_id" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password:</label>
                                <input type="text" name="password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Confirm Password:</label>
                                <input type="text" name="confirm_passwords" class="form-control " required>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="register_btn" class="btn btn-primary">Register Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>