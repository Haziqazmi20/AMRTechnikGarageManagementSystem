<?php
session_start();
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assignment</title>
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
        <li><a href="#" onclick="confirmLogout()">Logout</a></li>
    </ul>
    <div class="clearfix"></div>
</header>

<main>
    <div class="dashboard">
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h1>Task Assignment</h1>
                    <h3>Task Details</h3>
                    <i class='bx bx-filter'></i>
                </div>
                <table class="appointment-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Car Plate</th>
                            <th>Car Model</th>
                            <th>Car Mileage</th>
                            <th>Service Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Mechanic</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Retrieve and display accepted appointments
                        $sql = "SELECT appointments.*, tasks.mechanic_id, mechanic.name AS mechanic_name 
                                FROM appointments
                                LEFT JOIN tasks ON appointments.id = tasks.appointment_id
                                LEFT JOIN mechanic ON tasks.mechanic_id = mechanic.id
                                WHERE appointments.status = 'accepted'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $appointmentId = $row["id"];
                                
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["customerName"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carplate"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carmodel"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carmileage"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["service"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["preferredDate"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["preferredTime"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["mechanic_name"]) . "</td>";

                                if ($row["mechanic_id"]) {
                                    echo "<td><span class='assigned'>Assigned</span></td>";
                                } else {
                                    echo "<td><a href='task2.php?id=" . $row["id"] . "' class='assign-btn'>Assign Mechanic</a></td>";
                                }

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No accepted appointments found</td></tr>";
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
</script>

</body>
</html>
