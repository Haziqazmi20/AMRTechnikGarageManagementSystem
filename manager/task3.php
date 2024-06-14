<?php
session_start();
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Assigned Tasks</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">

    <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage</a></li>
        <li><a href="task.php">Task</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="servicehistory.php">Service History</a></li>
        <li><a href="servicedetails.php">Service</a></li>

    <div class="clearfix"></div>
        <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        <?php if (!isset($_SESSION["username"])): ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</header>
<main>

    <div class="dashboard">
        <div class="table-data">
            <!-- Assigned Tasks Table -->
            <div class="order">
                <div class="head">
                    <h3>Assigned Tasks</h3>
                </div>
                <table class="assigned-table">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Customer Name</th>
                            <th>Mechanic Name</th>
                            <th>Car Plate</th>
                            <th>Car Model</th>
                            <th>Service Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT tasks.id AS task_id, appointments.customerName, mechanic.name AS mechanic_name, tasks.carplate, tasks.carmodel, appointments.service, appointments.preferredDate, appointments.preferredTime, tasks.status
                                FROM tasks 
                                JOIN appointments ON tasks.appointment_id = appointments.id 
                                JOIN mechanic ON tasks.mechanic_id = mechanic.id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr id='task-row-" . htmlspecialchars($row["task_id"]) . "'>";
                                echo "<td>" . htmlspecialchars($row["task_id"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["customerName"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["mechanic_name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carplate"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carmodel"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["service"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["preferredDate"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["preferredTime"]) . "</td>";
                                echo "<td>";
                                echo "<form method='post' action='task3process.php'>";
                                echo "<input type='hidden' name='task_id' value='" . htmlspecialchars($row["task_id"]) . "'>";
                                echo "<select name='status'>";
                                echo "<option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>";
                                echo "<option value='in_progress'" . ($row['status'] == 'in_progress' ? ' selected' : '') . ">In Progress</option>";
                                echo "<option value='completed'" . ($row['status'] == 'completed' ? ' selected' : '') . ">Completed</option>";
                                echo "</select>";
                                echo "</td>";
                                echo "<td><button type='submit'>Update</button></form>";
                                if ($row['status'] == 'completed') {
                                    echo "<button class='done-btn' onclick='hideRow(" . htmlspecialchars($row["task_id"]) . ")'>Done</button>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No assigned tasks found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    function confirmLogout() {
        var result = confirm("Are you sure you want to logout?");
        if (result) {
            window.location.href = "logout.php";
        }
    }

    function hideRow(taskId) {
        var row = document.getElementById('task-row-' + taskId);
        row.style.display = 'none';
    }
</script>
</body>
</html>



