<?php
session_start();
include('db.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $item_id = $_POST['item_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Calculate total cost
    $total_cost = $price * $quantity;

    // Get supplier information
    $sqlSupplier = "SELECT supplier_name, supplier_contact FROM suppliers WHERE item_id = ?";
    $stmtSupplier = $conn->prepare($sqlSupplier);
    $stmtSupplier->bind_param('i', $item_id);
    $stmtSupplier->execute();
    $resultSupplier = $stmtSupplier->get_result();
    $supplier = $resultSupplier->fetch_assoc();
    $stmtSupplier->close();

    // Insert into purchases table
    $sqlPurchase = "INSERT INTO purchases (item_id, quantity, total_cost, supplier_name, supplier_contact) VALUES (?, ?, ?, ?, ?)";
    $stmtPurchase = $conn->prepare($sqlPurchase);
    $stmtPurchase->bind_param('iidss', $item_id, $quantity, $total_cost, $supplier['supplier_name'], $supplier['supplier_contact']);
    $stmtPurchase->execute();
    $stmtPurchase->close();

    // Update inventory quantity
    $sqlUpdateInventory = "UPDATE inventory SET quantity = quantity + ? WHERE id = ?";
    $stmtUpdateInventory = $conn->prepare($sqlUpdateInventory);
    $stmtUpdateInventory->bind_param('ii', $quantity, $item_id);
    $stmtUpdateInventory->execute();
    $stmtUpdateInventory->close();

    // Generate invoice
    $invoice = "Invoice for Purchase: \n";
    $invoice .= "Item ID: $item_id \n";
    $invoice .= "Quantity: $quantity \n";
    $invoice .= "Total Cost: RM$total_cost \n";
    $invoice .= "Supplier: " . $supplier['supplier_name'] . "\n";
    $invoice .= "Supplier Contact: " . $supplier['supplier_contact'] . "\n";

    // Output the invoice
    echo nl2br($invoice);
    exit;
} else {
    if (!isset($_GET['id'])) {
        echo "No item selected.";
        exit;
    }

    $item_id = $_GET['id'];

    // Fetch item details
    $sql = "SELECT * FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();

    if (!$item) {
        echo "Item not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="clerkstyle.css">
    <title>Buy Item</title>
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
    <h2>Buy Item</h2>
    <form action="buy-item.php" method="post">
        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" value="<?php echo htmlspecialchars($item['itemname']); ?>" readonly>

        <label for="price">Price per Unit (RM):</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" readonly>

        <label for="quantity">Quantity to Buy:</label>
        <input type="number" id="quantity" name="quantity" min="1" required>

        <button type="submit" name="submit">Buy</button>
    </form>
</div>

</body>
</html>
