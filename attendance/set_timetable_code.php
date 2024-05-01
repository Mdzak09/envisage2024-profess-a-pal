<?php
session_start();
include('includes/header.php');
// include('includes/navbar.php');
include('dbcon.php');

$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");


if (!isset($_SESSION['counter']) || $_SESSION['counter'] < 7) {
    if (!isset($_SESSION['counter'])) {
        $_SESSION['counter'] = 0;
    }

    // Check if form data is set in session
    // if (isset($_SESSION['form_data'])) {
    // Retrieve form data from session
    $formData = $_SESSION['form_data'];

    // Insert form data into database
    $idd = $con->real_escape_string($_SESSION['counter']);
    $subject1 = $con->real_escape_string($formData['sub1']);
    $subject2 = $con->real_escape_string($formData['sub2']);
    $subject3 = $con->real_escape_string($formData['sub3']);
    $subject4 = $con->real_escape_string($formData['sub4']);
    $subject5 = $con->real_escape_string($formData['sub5']);
    $subject6 = $con->real_escape_string($formData['sub6']);

    $msql = "INSERT INTO timetable (id, sub1, sub2, sub3, sub4, sub5, sub6) VALUES ('$idd', '$subject1', '$subject2', '$subject3', '$subject4', '$subject5', '$subject6')";
    $msql_run = mysqli_query($con, $msql);

    // Clear form data from session
    unset($_SESSION['form_data']);
    // }

    $_SESSION['counter']++;

    // Redirect to b.php
    if ($_SESSION['counter'] < 7) {
        $_SESSION['status'] = $days[$_SESSION['counter']];
        header("Location: set_timetable.php");
    } else {
        header("Location: index.php");
        $_SESSION['counter'] = 0;
    }
} else {
    header("Location: index.php");
    $_SESSION['counter'] = 0;
}

include('includes/footer.php');
