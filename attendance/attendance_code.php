<?php
include('dbcon.php');
include('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Loop through each subject
        foreach ($_POST as $key => $value) {
            // Check if the input is a subject (you may need to refine this condition depending on your form)
            if ($value == 'on') {
                // Sanitize input
                $name = $con->real_escape_string($key);

                // Insert data into the database
                $mammu = "INSERT INTO storage (classes) VALUES ('$name')";
                $mammu_run = mysqli_query($con, $mammu);

            }
        }
        header("Location: index.php");
        exit();
    }
}
