<?php
session_start();
include('db.php');

// Fetch all inventory items
$sqlItems = "SELECT * FROM inventory";
$resultItems = mysqli_query($conn, $sqlItems);

// Handle form submission for adding/editing suppliers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemId = $_POST['item_id'];
    $supplierName = $_POST['supplier_name'];
    $supplierContact = $_POST['supplier_contact'];
    
    // Check if the supplier already exists for the item
    $sqlCheck = "SELECT * FROM suppliers WHERE item_id = '$itemId'";
    $resultCheck = mysqli_query($conn, $sqlCheck);
    
    if (mysqli_num_rows($resultCheck) > 0) {
        // Update existing supplier
        $sqlUpdate = "UPDATE suppliers SET supplier_name = '$supplierName', supplier_contact = '$supplierContact' WHERE item_id = '$itemId'";
        mysqli_query($conn, $sqlUpdate);
    } else {
        // Insert new supplier
        $sqlInsert = "INSERT INTO suppliers (item_id, supplier_name, supplier_contact) VALUES ('$itemId', '$supplierName', '$supplierContact')";
        mysqli_query($conn, $sqlInsert);
    }
    
    header("Location: manage-supplier.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
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
        <h2>Manage Suppliers</h2>
        
        <form method="post" action="">
            <label for="item_id">Select Item:</label>
            <select name="item_id" id="item_id" required>
                <?php while ($row = mysqli_fetch_assoc($resultItems)): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['itemname']); ?></option>
                <?php endwhile; ?>
            </select><br>

            <label for="supplier_name">Supplier Name:</label>
            <input type="text" id="supplier_name" name="supplier_name" required><br>

            <label for="supplier_contact">Supplier Contact:</label>
            <input type="text" id="supplier_contact" name="supplier_contact" required><br>

            <button type="submit">Save Supplier</button>
        </form>
        
        <h3>Current Suppliers</h3>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Supplier Name</th>
                    <th>Supplier Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlSuppliers = "SELECT inventory.itemname, suppliers.supplier_name, suppliers.supplier_contact 
                                 FROM suppliers 
                                 JOIN inventory ON suppliers.item_id = inventory.id";
                $resultSuppliers = mysqli_query($conn, $sqlSuppliers);
                
                if (mysqli_num_rows($resultSuppliers) > 0):
                    while ($row = mysqli_fetch_assoc($resultSuppliers)):
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['itemname']); ?></td>
                            <td><?php echo htmlspecialchars($row['supplier_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['supplier_contact']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">No suppliers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
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
