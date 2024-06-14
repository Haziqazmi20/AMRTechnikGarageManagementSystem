<?php
include('db.php');

// Get the current date
$currentDate = date('Y-m-d');

// Fetch appointments for the current day
$sql = "SELECT tasks.id AS task_id, appointments.customerName, mechanic.name AS mechanic_name, tasks.carplate, tasks.carmodel, appointments.service, appointments.preferredDate, appointments.preferredTime, tasks.status 
        FROM tasks 
        JOIN appointments ON tasks.appointment_id = appointments.id 
        JOIN mechanic ON tasks.mechanic_id = mechanic.id
        WHERE appointments.preferredDate = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $currentDate);
$stmt->execute();
$result = $stmt->get_result();

// Array to store estimated times for each service type
$estimatedTimes = [
    'regular' => '~1-2 hours',
    'full' => '~2-4 hours',
    'major' => '~4-6 hours'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Today's Appointments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
        <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage</a></li>
        <li><a href="task.php">Task</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="#" onclick="confirmLogout()">Logout</a></li>
    </ul>
</header>
<div class="dashboard">
    <div class="head-title">
        <div class="left">
            <h1>Today's Appointments</h1>
        </div>
        <div class="right">
            <p>Total Appointments: <?php echo $result->num_rows; ?></p>
        </div>
    </div>

    <div class="table-data" style="margin-top: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
    <div class="order">
        <div class="head">
            <h3>Appointments for <?php echo $currentDate; ?></h3>
        </div>
        <table class="assigned-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; text-align: left;">Task ID</th>
                    <th style="padding: 10px; text-align: left;">Customer Name</th>
                    <th style="padding: 10px; text-align: left;">Mechanic Name</th>
                    <th style="padding: 10px; text-align: left;">Car Plate</th>
                    <th style="padding: 10px; text-align: left;">Car Model</th>
                    <th style="padding: 10px; text-align: left;">Service Type</th>
                    <th style="padding: 10px; text-align: left;">Date</th>
                    <th style="padding: 10px; text-align: left;">Time</th>
                    <th style="padding: 10px; text-align: left;">Status</th>
                    <th style="padding: 10px; text-align: left;">Estimated Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["task_id"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["customerName"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["mechanic_name"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["carplate"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["carmodel"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["service"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["preferredDate"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["preferredTime"]) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row["status"]) . "</td>";
                        // Display the estimated time based on service type
                        echo "<td style='padding: 10px;'>" . ($estimatedTimes[$row["service"]] ?? "Unknown") . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10' style='padding: 10px;'>No appointments found for today</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<script>
    function confirmLogout() {
        var result = confirm("Are you sure you want to logout?");
        if (result) {
            window.location.href = "logout.php";
        }
    }
</script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
