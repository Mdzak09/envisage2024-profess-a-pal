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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollNumber = mysqli_real_escape_string($conn, $_POST['Roll_Number']);
    $internal1Marks = mysqli_real_escape_string($conn, $_POST['Internal_1_Marks']);
    $internal2Marks = mysqli_real_escape_string($conn, $_POST['Internal_2_Marks']);
    $assignment1Marks = mysqli_real_escape_string($conn, $_POST['Assignment_1_Marks']);
    $assignment2Marks = mysqli_real_escape_string($conn, $_POST['Assignment_2_Marks']);

    $existingRecord = $conn->query("SELECT * FROM dtls WHERE Roll_Number = '$rollNumber'");

    if ($existingRecord->num_rows > 0) {
        $sql = "UPDATE dtls SET Internal_1 = '$internal1Marks', Internal_2 = '$internal2Marks', Assignment_1 = '$assignment1Marks', Assignment_2 = '$assignment2Marks' WHERE Roll_Number = '$rollNumber'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Entry is successfully updated!');</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $sql = "INSERT INTO dtls (Roll_Number, Internal_1, Internal_2, Assignment_1, Assignment_2) VALUES ('$rollNumber', '$internal1Marks', '$internal2Marks', '$assignment1Marks', '$assignment2Marks')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record created successfully');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>
