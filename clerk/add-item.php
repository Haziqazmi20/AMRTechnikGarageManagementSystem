<?php
session_start();
include('db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST['itemname'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Handle file upload
    if(isset($_FILES['image']['name']))
    {
        $image_name = $_FILES['image']['name'];
        
        // Check if an image is selected
        if(!empty($image_name))
        {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "Item-" . rand(0000, 9999) . "." . $ext;
            
            $src = $_FILES['image']['tmp_name'];
            $dst = "/images" . $image_name;
            
            $upload = move_uploaded_file($src, $dst);
            
            if(!$upload)
            {
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                header('Location: add-item.php');
                exit();
            }
        }
    }
    else
    {
        $image_name = ""; // Set default value
    }

    $sql = "INSERT INTO inventory (itemname, price, image_name, quantity) VALUES ('$itemName', '$price', '$image_name', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['add'] = "<div class='success'>Item Added Successfully.</div>";
        header("Location: inventory.php");
        exit();
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Item.</div>";
        header("Location: add-item.php");
        exit();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="clerkstyle.css">
    <title>Add Item</title>
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
    <h2>Add New Item</h2>
    <?php 
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Item Name:</td>
                <td><input type="text" name="itemname" placeholder="Enter Item Name"></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td><input type="text" name="price" placeholder="Enter Price"></td>
            </tr>
            <tr>
                <td>Quantity:</td>
                <td><input type="text" name="quantity" placeholder="Enter Quantity"></td>
            </tr>
            <tr>
                <td>Select Image:</td>
                <td><input type="file" name="image"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Item" class="btn-primary">
                </td>
            </tr>
        </table>
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
