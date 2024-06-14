<?php
session_start();
include('db.php');

// Handle form submission to update payment status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];
    $payment_status = $_POST['payment_status'];

    // Update payment status in the database
    $sqlUpdatePaymentStatus = "UPDATE services SET payment_status = ? WHERE id = ?";
    $stmtUpdatePaymentStatus = $conn->prepare($sqlUpdatePaymentStatus);
    $stmtUpdatePaymentStatus->bind_param("si", $payment_status, $service_id);
    $stmtUpdatePaymentStatus->execute();
    $stmtUpdatePaymentStatus->close();
}

// Fetch service history
$sqlServiceHistory = "
    SELECT services.*, appointments.customerName, tasks.service AS service_type, mechanic.name AS mechanic_assigned, payment_details.receipt_path
    FROM services
    JOIN appointments ON services.appointment_id = appointments.id
    JOIN tasks ON services.appointment_id = tasks.appointment_id
    JOIN mechanic ON tasks.mechanic_id = mechanic.id
    LEFT JOIN payment_details ON services.appointment_id = payment_details.appointment_id
";
$resultServiceHistory = mysqli_query($conn, $sqlServiceHistory);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service History</title>
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
</header>

<div class="dashboard">
    <h2>Service History</h2>
    <table>
        <tr>
            <th>Service ID</th>
            <th>Appointment ID</th>
            <th>Customer Name</th>
            <th>Service Type</th>
            <th>Mechanic Assigned</th>
            <th>Service Description</th>
            <th>Payment Status</th>
            <th>Items Used</th>
            <th>Amount to Pay</th> <!-- Add column header -->
            <th>Receipt</th>
            <th>Update Payment Status</th> <!-- Added column header -->
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultServiceHistory)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['appointment_id']; ?></td>
                <td><?php echo htmlspecialchars($row['customerName']); ?></td>
                <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                <td><?php echo htmlspecialchars($row['mechanic_assigned']); ?></td>
                <td><?php echo htmlspecialchars($row['service_description']); ?></td>
                <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                <td>
                    <?php
                    // Fetch items used for this service
                    $sqlItemsUsed = "SELECT inventory.itemname, service_items.quantity_used FROM service_items JOIN inventory ON service_items.item_id = inventory.id WHERE service_items.service_id = ?";
                    $stmtItemsUsed = $conn->prepare($sqlItemsUsed);
                    $stmtItemsUsed->bind_param("i", $row['id']);
                    $stmtItemsUsed->execute();
                    $resultItemsUsed = $stmtItemsUsed->get_result();
                    if ($resultItemsUsed->num_rows > 0) {
                        while ($item = $resultItemsUsed->fetch_assoc()) {
                            echo htmlspecialchars($item['itemname']) . ": " . $item['quantity_used'] . "<br>";
                        }
                    } else {
                        echo "No items used.";
                    }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($row['amount_to_pay']); ?></td>
                <td>
                    <?php if (!empty($row['receipt_path'])): ?>
                    <!-- Display download button if receipt path exists -->
                    <a href="download.php?file=<?php echo urlencode($row['receipt_path']); ?>" download>Download Receipt</a>
                    <?php else: ?>
                     <!-- Display a message if no receipt path exists -->
                    No receipt available
                    <?php endif; ?>
                </td>
                <td> <!-- Form to update payment status -->
                    <form method="post" action="">
                        <input type="hidden" name="service_id" value="<?php echo $row['id']; ?>">
                        <select name="payment_status">
                            <option value="pending" <?php if ($row['payment_status'] === 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="paid" <?php if ($row['payment_status'] === 'paid') echo 'selected'; ?>>Paid</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="servicedetails.php"><button>Update Service</button></a>
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
