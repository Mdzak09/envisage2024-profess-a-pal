<?php 
    // include('dbcon.php');
    include('includes/header.php');
    // include('includes/navbar.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Store form data in session
        $_SESSION['form_data'] = $_POST;
    
        // Redirect to a.php
        header("Location: set_timetable_code.php");
        exit;
    }
    
?>

    
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h5>
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
                         </h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Period-1 (9:15-10:15)</label>
                                <input type="text" name="sub1" class="form-control" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Period-2 (10:05-11:15)</label>
                                <input type="text" name="sub2" class="form-control" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Period-3 (11:15-12:15)</label>
                                <input type="text" name="sub3" class="form-control" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Period-4 (12:15-1:15)</label>
                                <input type="text" name="sub4" class="form-control" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Period-5 (2:00-3:00)</label>
                                <input type="text" name="sub5" class="form-control " >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Period-6 (3:00-4:00)</label>
                                <input type="text" name="sub6" class="form-control " >
                            </div>

                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="set_timetable_btn" class="btn btn-primary">Set</button>
                            </div>    
<?php  include('includes/footer.php')?>