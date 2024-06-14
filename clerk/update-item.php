<?php
session_start();
include('db.php');

// Check if the item ID is provided
if (!isset($_GET['id'])) {
    header("Location: inventory.php");
    exit();
}

$itemId = $_GET['id'];

// Fetch the item details from the database
$sql = "SELECT * FROM inventory WHERE id = $itemId";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $item = mysqli_fetch_assoc($result);
} else {
    // Handle the case where item is not found
    header("Location: inventory.php");
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = $_POST['itemname'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image_name = $item['image_name']; // Keep the current image name by default

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_tmp, "../images/" . $image_name);
    }

    // Update the item details in the database
    $sql = "UPDATE inventory SET 
            itemname = '$itemName', 
            price = $price, 
            image_name = '$image_name', 
            quantity = $quantity 
            WHERE id = $itemId";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the inventory page after successful update
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Item</title>
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
        <h2>Update Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="itemname">Item Name</label>
            <input type="text" id="itemname" name="itemname" value="<?php echo htmlspecialchars($item['itemname']); ?>" required>

            <label for="price">Price</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" required>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>

            <label for="image">Image</label>
            <input type="file" id="image" name="image">
            <?php if ($item['image_name']): ?>
                <img src="../images/<?php echo htmlspecialchars($item['image_name']); ?>" width="100px">
            <?php endif; ?>

            <button type="submit">Update Item</button>
        </form>
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
