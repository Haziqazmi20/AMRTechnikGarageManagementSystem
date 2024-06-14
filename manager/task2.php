<?php
session_start();
include('db.php');

// Check if appointment ID is provided
if (!isset($_GET['id'])) {
    header("Location: task.php");
    exit();
}

// Fetch appointment details based on the provided ID
$appointmentId = $_GET['id'];
$sql = "SELECT * FROM appointments WHERE id = $appointmentId";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // If appointment not found, redirect back to task page
    header("Location: task.php");
    exit();
}

$appointment = $result->fetch_assoc();

// Fetch available mechanics
$sqlMechanics = "SELECT * FROM mechanic WHERE status = 'available'";
$resultMechanics = $conn->query($sqlMechanics);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Mechanic</title>
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
                <h1>Assign Mechanic</h1>
                    <h3>Appointment Details</h3>
                </div>
                <table class="appointment-details">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Car Plate</th>
                            <th>Car Model</th>
                            <th>Service Type</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['customerName']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['carplate']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['carmodel']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['service']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['preferredDate']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['preferredTime']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="todo">
                <div class="head">
                    <h3>Available Mechanics</h3>
                </div>
                <form id="assignMechanicForm" action="task2process.php" method="post">
                    <input type="hidden" name="appointmentId" value="<?php echo $appointmentId; ?>">
                    <select name="mechanicId">
                        <?php
                        if ($resultMechanics->num_rows > 0) {
                            while ($mechanic = $resultMechanics->fetch_assoc()) {
                                echo "<option value='" . $mechanic['id'] . "'>" . $mechanic['name'] . "</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No available mechanics</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Assign</button>
                </form>
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
