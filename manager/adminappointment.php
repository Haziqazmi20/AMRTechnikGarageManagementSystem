<?php
session_start();
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['appointment_id'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $action = $_POST['action'];

    if ($action === 'accept') {
        // Update appointment status to 'accepted'
        $update_query = "UPDATE appointments SET status='accepted' WHERE id=$appointment_id";
        if (mysqli_query($conn, $update_query)) {
            // Fetch appointment details
            $fetch_query = "SELECT * FROM appointments WHERE id=$appointment_id";
            $fetch_result = mysqli_query($conn, $fetch_query);
            if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
                $appointment = mysqli_fetch_assoc($fetch_result);
                // Insert into car_status
                $carplate = $appointment['carplate'];
                $carmodel = $appointment['carmodel'];
                $carmileage = $appointment['carmileage'];
                $service = $appointment['service'];
                $status = 'pending';
                $insert_query = "INSERT INTO car_status (carplate, carmodel, carmileage, service, status, appointment_id) 
                                 VALUES ('$carplate', '$carmodel', '$carmileage', '$service', '$status', $appointment_id)";
                mysqli_query($conn, $insert_query);
                echo "Appointment accepted and car status updated successfully.";
            }
        } else {
            echo "Error updating appointment status: " . mysqli_error($conn);
        }
    } elseif ($action === 'decline') {
        // Update appointment status to 'declined'
        $query = "UPDATE appointments SET status='declined' WHERE id=$appointment_id";
        if (mysqli_query($conn, $query)) {
            echo "Appointment declined successfully.";
        } else {
            echo "Error updating appointment status: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
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

<div class="dashboard">
    <h2>Manage Appointments Requests</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Car Plate</th>
                <th>Car Model</th>
                <th>Car Mileage</th>
                <th>Preferred Date</th>
                <th>Preferred Time</th>
                <th>Service</th>
                <th>Additional Service</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch pending appointments
            $query = "SELECT * FROM appointments WHERE status='pending'";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['customerName']) ?></td>
                    <td><?= htmlspecialchars($row['carplate']) ?></td>
                    <td><?= htmlspecialchars($row['carmodel']) ?></td>
                    <td><?= htmlspecialchars($row['carmileage']) ?></td>
                    <td><?= htmlspecialchars($row['preferredDate']) ?></td>
                    <td><?= htmlspecialchars($row['preferredTime']) ?></td>
                    <td><?= htmlspecialchars($row['service']) ?></td>
                    <td><?= htmlspecialchars($row['addService']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <form action="adminappointment.php" method="post" style="display:inline;">
                            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($row['id']) ?>">
                            <input type="hidden" name="action" value="accept">
                            <button type="submit">Accept</button>
                        </form>
                        <form action="adminappointment.php" method="post" style="display:inline;">
                            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($row['id']) ?>">
                            <input type="hidden" name="action" value="decline">
                            <button type="submit">Decline</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
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
