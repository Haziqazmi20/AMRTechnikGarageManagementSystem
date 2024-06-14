<?php
session_start();
include('db.php');


// Function to delete a customer
if (isset($_POST['delete_customer'])) {
    $customerId = $_POST['customer_id'];
    $sql = "DELETE FROM customers WHERE id = '$customerId'";
    if ($conn->query($sql) === TRUE) {
        // Customer deleted successfully
        header("Refresh:0");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Function to edit a customer
if (isset($_POST['edit_customer'])) {
    $customerId = $_POST['customer_id'];
    // Redirect to edit customer page with customer ID
    header("Location: edit_customer.php?id=$customerId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
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

<main>
    <div class="head-title">
        <div class="left">
            <h1>Customer Details</h1>
        </div>
    </div>

    <div class="dashboard">
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>All Customers</h3>
                </div>
                <table class="customer-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>Car Plate</th>
                            <th>Car Model</th>
                            <th>Car Mileage</th>
                            <th>Car Color</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Retrieve and display all customer and car details
                        $sql = "SELECT customers.id, customers.fname, customers.phonenum, customers.email, customers.address, customers.username, 
                                       car_details.carplate, car_details.carmodel, car_details.carmileage, car_details.carcolor, car_details.description
                                FROM customers
                                LEFT JOIN car_details ON customers.username = car_details.username";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["fname"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["phonenum"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carplate"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carmodel"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carmileage"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["carcolor"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                                echo "<td>";
                                // Edit Button
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='customer_id' value='" . htmlspecialchars($row["id"]) . "'>";
                                echo "<button type='submit' name='edit_customer'>Edit</button>";
                                echo "</form>";
                                // Delete Button
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='customer_id' value='" . htmlspecialchars($row["id"]) . "'>";
                                echo "<button type='submit' name='delete_customer'>Delete</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12'>No customers found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

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
