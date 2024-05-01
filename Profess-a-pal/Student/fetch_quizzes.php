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

$sql = "SELECT name AS 'Quiz Name', descr AS 'Description', q_link AS 'Quiz Link' FROM Quizzes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $quizzes = [];
    while($row = $result->fetch_assoc()) {

        $quizLink = '<a href="' . $row['Quiz Link'] . '">' . $row['Quiz Link'] . '</a>';
        $row['Quiz Link'] = $quizLink;
        $quizzes[] = $row;
    }
    echo json_encode($quizzes);
} else {
    echo json_encode([]);
}
$conn->close();
?>
