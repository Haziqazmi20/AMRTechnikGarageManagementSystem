<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch completed task details for the logged-in customer
$sqlTaskDetails = "
    SELECT tasks.date AS service_date, appointments.carplate, appointments.carmodel, tasks.service AS service_type, mechanic.name AS mechanic_assigned, services.service_description
    FROM tasks
    JOIN appointments ON tasks.appointment_id = appointments.id
    JOIN mechanic ON tasks.mechanic_id = mechanic.id
    LEFT JOIN services ON appointments.id = services.appointment_id
    WHERE tasks.status = 'completed' AND tasks.username = '$username'
    ORDER BY tasks.date DESC
";
$resultTaskDetails = mysqli_query($conn, $sqlTaskDetails);

function getNextServiceDate($lastServiceDate) {
    // Assuming the next service is 6 months from the last service date
    $date = new DateTime($lastServiceDate);
    $date->add(new DateInterval('P6M'));
    return $date->format('Y-m-d');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
        <li><a href="index.php">Home</a></li>
        <li><a href="appointment.php">Book</a></li>
        <li><a href="contact.php">Contact</a></li>
        <script>
            function confirmLogout() {
                var result = confirm("Are you sure you want to logout?");
                if (result) {
                    window.location.href = "logout.php";
                }
            }
        </script>
        <?php if (!isset($_SESSION["username"])): ?>
            <li><a href="login.php">Login</a></li>
        <?php else: ?>
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        <?php endif; ?>
    </ul>
    <div class="clearfix"></div>
</header>

<div class="dashboard">
    <h2>Service History</h2>
    <table>
        <thead>
            <tr>
                <th>Service Date</th>
                <th>Car Plate</th>
                <th>Car Model</th>
                <th>Service Type</th>
                <th>Mechanic Assigned</th>
                <th>Service Description</th>
                <th>Next Service Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultTaskDetails) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($resultTaskDetails)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['service_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['carplate']); ?></td>
                        <td><?php echo htmlspecialchars($row['carmodel']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['mechanic_assigned']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_description']); ?></td>
                        <td><?php echo getNextServiceDate($row['service_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">No service records found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
