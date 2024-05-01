<?php

$host = 'database-1.crssaayci4ph.ap-southeast-2.rds.amazonaws.com';
$username = 'admin';
$password = 'Rockleone123';
$database = 'student_dtls';
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rollnumber1 = $_POST['roll1'];
$rollnumber2 = $_POST['roll2'];
$similarity_percentage = $_POST['percentage'];

// Check if both roll numbers exist in the dtls table
$check_sql = "SELECT COUNT(*) AS count FROM dtls WHERE Roll_Number IN ('$rollnumber1', '$rollnumber2')";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count < 2) {
    echo "<script>alert('One or both roll numbers do not exist in the database. Please enter valid roll numbers.');</script>";
} else {
    // Calculate assignment_2_grade based on similarity_percentage
    if ($similarity_percentage >= 0 && $similarity_percentage <= 20) {
        $assignment_2_grade = 5;
    } elseif ($similarity_percentage > 20 && $similarity_percentage <= 40) {
        $assignment_2_grade = 4;
    } elseif ($similarity_percentage > 40 && $similarity_percentage <= 60) {
        $assignment_2_grade = 3;
    } elseif ($similarity_percentage > 60 && $similarity_percentage <= 80) {
        $assignment_2_grade = 2;
    } elseif ($similarity_percentage > 80 && $similarity_percentage <= 100) {
        $assignment_2_grade = 1;
    } else {
        $assignment_2_grade = NULL;
    }

    // Insert into similarity_grades table
    $sql = "INSERT INTO similarity_grades (roll_number_1, roll_number_2, similarity_percentage, assignment_2_grade) 
            VALUES ('$rollnumber1', '$rollnumber2', '$similarity_percentage', '$assignment_2_grade')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Update dtls table
    $update_sql = "UPDATE dtls d
                   JOIN similarity_grades s ON (d.Roll_Number = s.roll_number_1 OR d.Roll_Number = s.roll_number_2)
                   SET d.Assignment_2 = s.assignment_2_grade";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Assignment 2 grades updated successfully');</script>";
    } else {
        echo "Error updating assignment 2 grades: " . $conn->error;
    }
}

$conn->close();
?>
