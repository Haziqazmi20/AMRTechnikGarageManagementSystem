<?php
session_start();
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="clerkstyle.css">
    <title>Inventory</title>
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
    <?php if(!isset($_SESSION["clerk"])): ?>
        <li><a href="login.php">Login</a></li>
    <?php else: ?>
        <li><a href="#" onclick="confirmLogout()">Logout</a></li>
    <?php endif; ?>
</header>

<div class="inventory-container">
    <h2>Inventory</h2>
    <div class="add-item-button">
        <a href="add-item.php"><button>Add Item</button></a>
    </div>
    <table>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Supplier Name</th>
            <th>Supplier Contact</th>
            <th>Actions</th>
        </tr>

        <?php 
        //Create a SQL Query
        $sql = "SELECT inventory.*, suppliers.supplier_name, suppliers.supplier_contact 
                FROM inventory 
                LEFT JOIN suppliers ON inventory.id = suppliers.item_id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        //Create Serial Number Variable and Set Default Value as 1
        $sn = 1;

        if($count > 0) {

            while($row = mysqli_fetch_assoc($res)) {
                //get the values from individual columns
                $id = $row['id'];
                $itemname = $row['itemname'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $available = $row['quantity'];
                $supplier_name = $row['supplier_name'];
                $supplier_contact = $row['supplier_contact'];
                ?>

                <tr>
                    <td><?php echo $sn++; ?>. </td>
                    <td><?php echo htmlspecialchars($itemname); ?></td>
                    <td>RM<?php echo htmlspecialchars($price); ?></td>
                    <td>
                        <?php  
                        //Check whether we have image or not
                        if($image_name == "") {
                            //When do not have image, Display Error Message
                            echo "<div class='error'>Image not Added.</div>";
                        } else {
                            //When Have Image, Display Image
                            ?>
                            <img src="../images<?php echo htmlspecialchars($image_name); ?>" width="100px">
                            <?php
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($available); ?></td>
                    <td><?php echo htmlspecialchars($supplier_name); ?></td>
                    <td><?php echo htmlspecialchars($supplier_contact); ?></td>
                    <td>
                        <a href="update-item.php?id=<?php echo $id; ?>" class="btn-secondary">Update Item</a><br><br>
                        <a href="buy-item.php?id=<?php echo $id; ?>" class="btn-primary">Buy Item</a><br><br>
                    </td>
                </tr>

                <?php
            }
        } else {
            echo "<tr> <td colspan='8' class='error'> Item not Added Yet. </td> </tr>";
        }
        ?>
    </table>
</div>
<!--Inventory List-->

</body>
</html>
