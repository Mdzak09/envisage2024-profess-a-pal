<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .result {
        margin-bottom: 10px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding-left: 30%;
    }

    .result span {
        font-weight: bold;
        color: #555;
    }

    .info {
        text-align: center;
        font-size: 14px;
        color: #777;
        margin-top: 20px;
    }
</style>




<?php
include('dbcon.php');
$query = "SELECT DISTINCT sub1, sub2, sub3, sub4, sub5, sub6 FROM timetable";
$result = $con->query($query);

$courses = [];
while ($row = $result->fetch_assoc()) {
    foreach ($row as $value) {
        if (!empty($value) && !in_array($value, $courses)) {
            $courses[] = $value;
        }
    }
}
$val = 0;
foreach ($courses as $course) {


    for ($i = 0; $i < 7; $i++) {
        // echo $numericArray[$i] . " ";

        $query3 = " SELECT * FROM timetable WHERE id = '$i' AND (sub1 = '$course' OR sub2 = '$course' OR sub3 = '$course' OR sub4 = '$course' OR sub5 = '$course' OR sub6 = '$course')";
        $query3_run = $con->query($query3);
        if (mysqli_num_rows($query3_run) > 0) {

            $noofdays = "SELECT days FROM sem_weekdays WHERE day = '$i';";
            $noofdays_run = $con->query($noofdays);
            $noofdays_row = $noofdays_run->fetch_assoc();

            if ($noofdays_row) {
                $val = $noofdays_row['days'] + $val;
            }
        }
    }

    $escaped_course = mysqli_real_escape_string($con, $course);

    $query2 = "INSERT INTO subjects (sub,total) VALUES ('$escaped_course','$val')";
    $query2_run = $con->query($query2);
    $val = 0;
}


$query = "SELECT SUM(total) AS total_sum FROM subjects";
$result = $con->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        $total_sum = $row['total_sum'];
        // echo "<div class='result'>Total Classes: <span>$total_sum</span></div>";
    }
}

$query = "SELECT COUNT(*) AS row_count FROM storage";
$result = $con->query($query);

if ($result) {
    $mow = $result->fetch_assoc();
    if ($mow) {
        $mow_count = $mow['row_count'];
        // echo "<div class='result'>Number of Classes Attended: <span>$mow_count</span></div>";
    } else {
        // echo "<div class='result'>No Classes Attended</div>";
    }
}

$s75 = round($total_sum * 0.75, 0);
$average = round(($mow_count / $total_sum) * 100, 0);

// echo "<div class='result'>Average attendance: <span>$average%</span></div>";
// echo "<div class='result'>You need $s75 classes to reach 75% Attendance</div>";
?>
<div class="container">
        <h1>Attendance Summary</h1>
        <div class="result">
            <span>Total Classes:</span> <?php echo $total_sum; ?>
        </div>
        <div class="result">
            <span>Number of Classes Attended:</span> <?php echo $mow_count; ?>
        </div>
        <?php if ($total_sum > 0) : ?>
            <div class="result">
                <span>Average Attendance:</span> <?php echo $average; ?>%
            </div>
            <div class="result">
                <span>Classes Needed for 75% Attendance:</span> <?php echo $s75; ?>
            </div>
        <?php else : ?>
            <div class="result">No attendance data available.</div>
        <?php endif; ?>
        <p class="info">Note: Average attendance is calculated based on classes attended.</p>
    </div>
