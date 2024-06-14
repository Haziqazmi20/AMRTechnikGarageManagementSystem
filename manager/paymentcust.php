<?php
session_start();
require('db.php');

// Check if the user is logged in and is a manager

// Handle form submission for updating payment details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['payment_id']) && isset($_POST['amount_to_pay']) && isset($_POST['payment_status'])) {
        $paymentId = $_POST['payment_id'];
        $amountToPay = $_POST['amount_to_pay'];
        $paymentStatus = $_POST['payment_status'];

        // Update payment details
        $sqlUpdate = "UPDATE payment_details SET amount_to_pay = ?, payment_status = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("dii", $amountToPay, $paymentStatus, $paymentId);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }
}

// Fetch payment details
$sql = "SELECT * FROM payment_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
        <li><a href="index.php">Home</a></li>
        <li><a href="appointment.php">Book</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</header>

<div class="payment-container">
    <h2>Payment Management</h2>
    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Amount to Pay</th>
                <th>Payment Status</th>
                <th>Receipt</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="post" action="">
                    <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><input type="text" name="amount_to_pay" value="<?php echo $row['amount_to_pay']; ?>"></td>
                    <td>
                        <select name="payment_status">
                            <option value="0" <?php echo $row['payment_status'] == 0 ? 'selected' : ''; ?>>Pending</option>
                            <option value="1" <?php echo $row['payment_status'] == 1 ? 'selected' : ''; ?>>Paid</option>
                        </select>
                    </td>
                    <td><?php echo $row['receipt_path']; ?></td>
                    <td><button type="submit">Update</button></td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
