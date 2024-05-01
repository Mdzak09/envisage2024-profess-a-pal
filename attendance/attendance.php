<?php
include('dbcon.php');
include('includes/header.php');
?>

<style>
    .nalla {
        /* background-color: red; */
        margin-left: 5%;
        /* margin-bottom: 5px; */
        padding: 11px 30px 1px 8px;
    }

    .nalla2 {
        background-color: rgb(244, 244, 244);
        /* border: 1px solid black; */
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 15px;
        border-radius: 12px;
        /* margin-left: 20%; */
        font-size: large;

    }

    input {
        margin-left: 3%;
    }

    .buttun {
        display: inline-block;
        padding: 4px 28px;
        margin: 10px;
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        color: #fff;
        background-image: linear-gradient(to bottom right, #000000, #65abff);
        border: none;
        border-radius: 40px;
        box-shadow: 0px 4px 0px #0072ff;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .buttun:hover {
        transform: translateY(-2px);
        box-shadow: 0px 6px 0px #000000;
    }

    .buttun:active {
        transform: translateY(0px);
        box-shadow: none;
        background-image: linear-gradient(to bottom right, #65abff, #000000);
    }

    .buttun:before,
    .buttun:after {
        content: "";
        position: absolute;
        width: 0;
        height: 0;
    }

    .buttun:before {
        top: -3px;
        left: -3px;
        border-radius: 40px;
        border-top: 3px solid #fff;
        border-left: 3px solid #fff;
    }

    .buttun:after {
        bottom: -3px;
        right: -3px;
        border-radius: 40px;
        border-bottom: 3px solid #fff;
        border-right: 3px solid #fff;
    }
</style>
<?php

// Get the current day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
$id = date('w');

$getsubjects = "SELECT * FROM timetable WHERE id = '$id'";
$getsubjects_run = $con->query($getsubjects);

// Checking if the query was successful
if ($getsubjects_run) {
    $row = $getsubjects_run->fetch_assoc();

    $sub1 = $row['sub1'];
    $sub2 = $row['sub2'];
    $sub3 = $row['sub3'];
    $sub4 = $row['sub4'];
    $sub5 = $row['sub5'];
    $sub6 = $row['sub6'];

    $todays_subs = array($sub1, $sub2, $sub3, $sub4, $sub5, $sub6);
?>
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header text-center">
                            <h5>Todays Classes</h5>
                        </div>
                        <div class="card-body">
                            <form action="attendance_code.php" method="post">
                                <?php
                                if (!empty($sub1) || !empty($sub2) || !empty($sub3) || !empty($sub4) || !empty($sub5) || !empty($sub6)) {
                                ?>
                                    <?php
                                    foreach ($todays_subs as $subject) {
                                        if ($subject !== null && !empty($subject)) {
                                    ?>
                                            <div class="nalla">
                                                <div class="checkbox-container form-group nalla2">
                                                    <input type="checkbox" id="<?= $subject ?>" name="<?= $subject ?>">
                                                    <label for="<?= $subject ?>"><?= $subject ?></label><br>
                                                </div>

                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <input type="submit" name="submit" value="Submit" style="display: block; margin: 10px auto; " class="buttun">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php
                                } else {
                                    echo '<div class="text-center"><h5>No classes Today</h5></div>';
                                }
                            } else {
                                echo "Error: " . $con->error;
                            }

                            include('includes/footer.php');
?>