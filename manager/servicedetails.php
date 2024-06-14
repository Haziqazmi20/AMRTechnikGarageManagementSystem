<?php
session_start();
include('db.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = $_POST['appointment_id'];
    $service_type = $_POST['service_type'];
    $mechanic_assigned = $_POST['mechanic_assigned'];
    $service_description = $_POST['service_description'];
    $items_used = $_POST['items_used'];
    $amount_to_pay = $_POST['amount_to_pay']; // Added

    // Check if a service record already exists for the selected appointment ID
    $sqlCheckService = "SELECT id FROM services WHERE appointment_id = ?";
    $stmtCheckService = $conn->prepare($sqlCheckService);
    $stmtCheckService->bind_param("i", $appointment_id);
    $stmtCheckService->execute();
    $resultCheckService = $stmtCheckService->get_result();

    if ($resultCheckService->num_rows > 0) {
        // Update existing service record
        $row = $resultCheckService->fetch_assoc();
        $service_id = $row['id'];

        $sqlUpdateService = "UPDATE services SET service_type = ?, mechanic_assigned = ?, service_description = ?, amount_to_pay = ? WHERE id = ?"; // Updated
        $stmtUpdateService = $conn->prepare($sqlUpdateService);
        $stmtUpdateService->bind_param("ssss", $service_type, $mechanic_assigned, $service_description, $amount_to_pay, $service_id); // Updated
        $stmtUpdateService->execute();
        $stmtUpdateService->close();
    } else {
        // Insert new service record
        $sqlService = "INSERT INTO services (appointment_id, service_type, mechanic_assigned, service_description, amount_to_pay) VALUES (?, ?, ?, ?, ?)"; // Updated
        $stmtService = $conn->prepare($sqlService);
        $stmtService->bind_param("issss", $appointment_id, $service_type, $mechanic_assigned, $service_description, $amount_to_pay); // Updated
        $stmtService->execute();
        $service_id = $stmtService->insert_id;
        $stmtService->close();
    }

    // Update inventory and record items used
    foreach ($items_used as $item_id => $quantity_used) {
        if ($quantity_used > 0) {
            // Update inventory quantity
            $sqlUpdateInventory = "UPDATE inventory SET quantity = quantity - ? WHERE id = ?";
            $stmtUpdateInventory = $conn->prepare($sqlUpdateInventory);
            $stmtUpdateInventory->bind_param("ii", $quantity_used, $item_id);
            $stmtUpdateInventory->execute();
            $stmtUpdateInventory->close();

            // Insert item usage record
            $sqlItemUsage = "INSERT INTO service_items (service_id, item_id, quantity_used) VALUES (?, ?, ?)";
            $stmtItemUsage = $conn->prepare($sqlItemUsage);
            $stmtItemUsage->bind_param("iii", $service_id, $item_id, $quantity_used);
            $stmtItemUsage->execute();
            $stmtItemUsage->close();
        }
    }

    echo "Service record updated successfully.";
}

// Fetch inventory items
$sqlItems = "SELECT * FROM inventory";
$resultItems = mysqli_query($conn, $sqlItems);

// Fetch completed appointments with task and mechanic details
$sqlAppointments = "
    SELECT appointments.id AS appointment_id, appointments.customerName, tasks.service, tasks.mechanic_id, mechanic.name AS mechanic_name
    FROM tasks
    JOIN appointments ON tasks.appointment_id = appointments.id
    JOIN mechanic ON tasks.mechanic_id = mechanic.id
    WHERE tasks.status = 'completed'
";
$resultAppointments = mysqli_query($conn, $sqlAppointments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Service Update</title>
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
        <li><a href="servicedetails.php">Service</a></li>
        <div class="clearfix"></div>
    <script>
        function confirmLogout() {
            var result = confirm("Are you sure you want to logout?");
            if (result) {
                window.location.href = "logout.php";
            }
        }
    </script>
</header>

<div class="dashboard">
    <h2>Update Service</h2>
    <form method="POST" action="servicedetails.php">
        <label for="appointment_id">Appointment ID:</label>
        <select name="appointment_id" id="appointment_id" required>
            <?php while ($row = mysqli_fetch_assoc($resultAppointments)): ?>
                <option value="<?php echo $row['appointment_id']; ?>" data-service-type="<?php echo htmlspecialchars($row['service']); ?>" data-mechanic-assigned="<?php echo htmlspecialchars($row['mechanic_name']); ?>">
                    <?php echo $row['appointment_id']; ?> - <?php echo htmlspecialchars($row['customerName']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="service_type">Service Type:</label>
        <input type="text" name="service_type" id="service_type" readonly>

        <label for="mechanic_assigned">Mechanic Assigned:</label>
        <input type="text" name="mechanic_assigned" id="mechanic_assigned" readonly>

        <label for="service_description">Service Description:</label>
        <textarea name="service_description" id="service_description" required></textarea>

        <label for="amount_to_pay">Amount to Pay:</label>
        <input type="number" name="amount_to_pay" id="amount_to_pay" step="0.01" required>

        <label for="items_used">Items Used:</label>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Available Quantity</th>
                <th>Quantity Used</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultItems)): ?>
                <tr>
                <td><?php echo htmlspecialchars($row['itemname']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td>
                        <input type="number" name="items_used[<?php echo $row['id']; ?>]" min="0" max="<?php echo $row['quantity']; ?>" value="0">
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <button type="submit">Update Service</button>
    </form>
</div>

<script>
    document.getElementById('appointment_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('service_type').value = selectedOption.getAttribute('data-service-type');
        document.getElementById('mechanic_assigned').value = selectedOption.getAttribute('data-mechanic-assigned');
});
// Trigger change event to set initial values
document.getElementById('appointment_id').dispatchEvent(new Event('change'));
</script>
</body>
</html>         


