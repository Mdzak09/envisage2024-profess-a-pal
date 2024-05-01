<?php

include('dbcon.php');
 
    // Construct INSERT query
    $rsql = "TRUNCATE TABLE timetable;";
        
    // Execute the query using custom function
    $rsql_run = mysqli_query($con, $rsql);
    $_SESSION['counter']=0;

    header("Location: index.php");


