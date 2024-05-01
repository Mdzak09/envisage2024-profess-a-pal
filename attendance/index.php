<?php
include('dbcon.php');
include('includes/header.php');
$query = "SELECT start_date, end_date FROM sem_dates";
$result = mysqli_query($con, $query);

if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Get start_date and end_date from the database
    $start_date = new DateTime($row['start_date']);
    $end_date = new DateTime($row['end_date']);
    
    // Calculate the difference between end_date and start_date
    $interval = $start_date->diff($end_date);
    
    // Get the difference in months and days
    $months = $interval->format('%m');
    $days = $interval->format('%d');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f6f6f6;
        }

        .container {
            display: flex;
            background-color: #f6f6f6;
            border-radius: 8px;
            overflow: hidden;
            height: 100vh;
            justify-content: center;
            align-items: center;

        }

        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            color: rgb(0, 0, 0);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 10px;
            height: 95vh;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            margin-bottom:40px;
            font-size: 40px;
            color: black;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
            padding-bottom:20px ;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: black;
            font-size: 20px;
            
            transition: color 0.3s;
        }

        .sidebar ul li a:hover {
            color: rgb(0, 0, 128);
            text-decoration: underline;
        }

        .content {
            flex: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            height: 95vh;
        }

        .content h1 {
            color: black;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .content p {
            color: black;
            font-size: 16px;
            line-height: 1.6;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <!-- <h3>Profess-a-pal</h3> -->
            <ul>
                <li><a href="set_timetable_code.php">Set TimeTable</a></li>
                <li><a href="reset_timetable_code.php">Reset TimeTable</a></li>
                <li><a href="days.php">Set Semester Dates</a></li>
                <li><a href="attendance.php">Attendance</a></li>
                <li><a href="view_attendance.php">View Attendance</a></li>
            </ul>
        </div>
        <div class="content">
            <h2><?php echo $months ?> Months <?php echo $days ?> Days Left </h2>
            <p>Prepare your Self</p>
        </div>
    </div>
</body>
</html>

<?php include('includes/footer.php');?>