<?php
$host = 'database-1.crssaayci4ph.ap-southeast-2.rds.amazonaws.com';
$username = 'admin';
$password = 'Rockleone123';
$database = 'student_dtls';
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $name = $_POST['quizName']; 
    $link = $_POST['quizLink']; 
    $descr = $_POST['description']; 

    $stmt = $conn->prepare("INSERT INTO Quizzes (name, descr, q_link) VALUES (?, ?, ?)"); 
    $stmt->bind_param("sss", $name, $descr, $link);

    if ($stmt->execute()) {
        echo "<script>alert('New record created successfully');</script>"; 
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
