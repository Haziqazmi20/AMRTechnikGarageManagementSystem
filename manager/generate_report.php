<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['report_type'])) {
    $report_type = $_GET['report_type'];

    if ($report_type === "item") {
        // Fetch item usage data
        $sqlItemUsage = "
            SELECT inventory.itemname, SUM(service_items.quantity_used) AS total_quantity_used
            FROM service_items
            JOIN inventory ON service_items.item_id = inventory.id
            GROUP BY inventory.itemname
        ";
        $resultItemUsage = mysqli_query($conn, $sqlItemUsage);

        // Fetch item purchase data
        $sqlItemPurchase = "
            SELECT purchases.item_id, inventory.itemname, SUM(purchases.quantity) AS total_quantity_purchased, SUM(purchases.total_cost) AS total_amount_paid
            FROM purchases
            JOIN inventory ON purchases.item_id = inventory.id
            GROUP BY purchases.item_id
        ";
        $resultItemPurchase = mysqli_query($conn, $sqlItemPurchase);
    }
} else {
    // Redirect to report page if report type is not specified
    header("Location: report.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
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
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        </ul>
    </header>

    <div class="dashboard">
        <h2>Item Report</h2>
        <?php if ($report_type === "item"): ?>
            <h3>Item Usage Details</h3>
            <table>
                <tr>
                    <th>Item Name</th>
                    <th>Total Quantity Used</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($resultItemUsage)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['itemname']); ?></td>
                        <td><?php echo $row['total_quantity_used']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <h3>Item Purchase Details</h3>
            <table>
                <tr>
                    <th>Item Name</th>
                    <th>Total Quantity Purchased</th>
                    <th>Total Amount Paid</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($resultItemPurchase)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['itemname']); ?></td>
                        <td><?php echo $row['total_quantity_purchased']; ?></td>
                        <td><?php echo $row['total_amount_paid']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <!-- Add download button for PDF -->
            <form action="generate_item_report.php" method="post">
                <input type="hidden" name="report_type" value="item">
                <button type="submit">Download PDF</button>
            </form>
        <?php endif; ?>
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


