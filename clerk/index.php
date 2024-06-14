<?php
session_start();
include('db.php');

// Fetch total number of items
$sqlTotalItems = "SELECT COUNT(*) AS total FROM inventory";
$resultTotalItems = mysqli_query($conn, $sqlTotalItems);
$totalItems = mysqli_fetch_assoc($resultTotalItems)['total'];

// Fetch total number of suppliers
$sqlTotalSuppliers = "SELECT COUNT(*) AS total FROM suppliers";
$resultTotalSuppliers = mysqli_query($conn, $sqlTotalSuppliers);
$totalSuppliers = mysqli_fetch_assoc($resultTotalSuppliers)['total'];

// Fetch items with low stock
$sqlLowStock = "SELECT * FROM inventory WHERE quantity < 5";
$resultLowStock = mysqli_query($conn, $sqlLowStock);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clerk Dashboard</title>
    <link rel="stylesheet" href="clerkstyle.css">
</head>
<body>
    <header>
        <a href="index.php" class="logo">AMR TECHNIK</a>
        <ul class="navlist">
            <li><a href="index.php">Home</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="manage-supplier.php">Supplier</a></li>
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        </ul>
    </header>
    <div class="inventory-container">
        <div class="dashboard">
            <h2>Clerk Dashboard</h2>
            <div class="total-items">
                <h3>Total Items in Inventory</h3>
                <p><?php echo $totalItems; ?></p>
            </div>

            <div class="total-suppliers">
                <h3>Total Suppliers</h3>
                <p><?php echo $totalSuppliers; ?></p>
            </div>

            <div class="low-stock-items">
                <h3>Items Low in Stock</h3>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($resultLowStock) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($resultLowStock)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['itemname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3">No items are low in stock.</td></tr>
                        <?php endif; ?>
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

