<?php
include('dbcon.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semester Period</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            color: #555;
        }

        input[type="date"] {
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 5px;
            color: #666;
            display: block;
            /* Display items horizontally */
            width: auto;
            /* Set width for each item */
            text-align: center;
        }

        p {
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Semester Period</h1>
    <form method="post">
        <label for="startDate">Semester Start Date:</label>
        <input type="date" id="startDate" name="startDate" required>
        <br>
        <label for="endDate">Semester End Date:</label>
        <input type="date" id="endDate" name="endDate" required>
        <br>
        <button type="submit" name="submit">Set</button>
    </form>

    <?php


    // Function to fetch holidays from Nager.Date API for India
    function fetchHolidaysForIndia($year)
    {
        $apiUrl = "https://date.nager.at/api/v3/PublicHolidays/$year/IN";
        $response = file_get_contents($apiUrl);
        if ($response === false) {
            echo '<h3>Error: Failed to fetch holiday data</h3>';
            return array();
        }
        $holidays = json_decode($response, true);
        if ($holidays === null) {
            return array();
        }
        return $holidays;
    }

    // Function to count weekdays and total days
    function countWeekdays($startDate, $endDate, $holidays)
    {
        $result = array(
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0
        );

        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $totalDays = 0;
        $totalWorkingDays = 0;

        while ($currentDate <= $endDate) {
            $dayOfWeek = date('l', $currentDate);
            $currentDateString = date('Y-m-d', $currentDate);

            if (!in_array($currentDateString, $holidays)) {
                $result[$dayOfWeek]++;
                if ($dayOfWeek != 'Sunday') {
                    $totalWorkingDays++;
                }
            }

            $totalDays++;
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return array('weekdays' => $result, 'totalDays' => $totalDays, 'totalWorkingDays' => $totalWorkingDays);
    }

    if (isset($_POST['submit'])) {

        $rsql = "TRUNCATE TABLE subjects;";
        $rsql_run = mysqli_query($con, $rsql);
        
        $rsql = "TRUNCATE TABLE storage;";
        $rsql_run = mysqli_query($con, $rsql);

        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $query = "SELECT * FROM sem_dates";
        $result = mysqli_query($con, $query);
        if ($result) {
            if ($result->num_rows > 0) {
                $rsql = "TRUNCATE TABLE sem_dates";
                $rsql_run = mysqli_query($con, $rsql);
                $rsql2 = "TRUNCATE TABLE sem_weekdays";
                $rsql2_run = mysqli_query($con, $rsql2);
            }
            $result->free();
        }


        $year = date('Y', strtotime($startDate)); // Get the year from the start date
        $holidays = fetchHolidaysForIndia($year);
        $startFormattedDate = date('j-F-Y', strtotime($startDate)); // Format start date
        $endFormattedDate = date('j-F-Y', strtotime($endDate)); // Format end date


        $countData = countWeekdays($startDate, $endDate, $holidays);
        $weekdaysCount = $countData['weekdays'];
        $totalDays = $countData['totalDays'];
        $totalWorkingDays = $countData['totalWorkingDays'];

        // echo "<h2 style='color: #007bff;'>Weekdays Count from $startFormattedDate to $endFormattedDate</h2>";
        // echo '<ul>';
        // echo '</ul>';

        // echo "<p>Total Days: $totalDays</p>";
        // echo "<p>Total Working Days: $totalWorkingDays</p>";
        $counter = 0;
        foreach ($weekdaysCount as $day => $count) {
            $mam = "INSERT INTO sem_weekdays (day,days) VALUES ('$counter','$count')";
            $mam_run = mysqli_query($con, $mam);
            $counter++;
        }
        $counter = 0;

        $ma = "INSERT INTO sem_dates (start_date,end_date) VALUES ('$startDate','$endDate')";
        $ma_run = mysqli_query($con, $ma);
        header("Location: index.php");
        exit();
    }
    ?>

</body>

</html>