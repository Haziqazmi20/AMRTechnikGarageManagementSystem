<?php
require('db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch the appointment ID and customer name
$appointmentId = $_POST['appointment_id'];
$username = $_SESSION['username'];

// Fetch the amount to pay based on the completed services
$sqlAmount = "SELECT amount_to_pay FROM services WHERE appointment_id = ?";
$stmtAmount = $conn->prepare($sqlAmount);
$stmtAmount->bind_param('i', $appointmentId);
$stmtAmount->execute();
$resultAmount = $stmtAmount->get_result();
$amountToPay = $resultAmount->fetch_assoc()['amount_to_pay'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
        $uploadDir = 'C:/xampp/htdocs/AMRTechnik/images/'; // Directory path for file upload
        $uploadFile = $uploadDir . basename($_FILES['receipt']['name']);

        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $uploadFile)) {
            // Save receipt info to the database
            $relativePath = 'images/' . basename($_FILES['receipt']['name']); // Relative path for database
            
            $sqlReceipt = "INSERT INTO payment_details (customerName, appointment_id, receipt_path, amount_paid) VALUES (?, ?, ?, ?)";
            $stmtReceipt = $conn->prepare($sqlReceipt);
            $stmtReceipt->bind_param('sdsd', $username, $appointmentId, $relativePath, $amountToPay);
            
            if ($stmtReceipt->execute()) {
                echo "Receipt uploaded successfully.";
            } else {
                echo "Error uploading receipt.";
            }
            $stmtReceipt->close();
        } else {
            echo "Error uploading receipt.";
        }
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Item-" . rand(0000, 9999) . "." . $ext;
        
        $src = $_FILES['image']['tmp_name'];
        $dst = "AMRTechnik/images/" . $image_name;
        
        if (move_uploaded_file($src, $dst)) {
            $imagePath = 'images/' . $image_name; // Relative path for database
            
            // Insert image path into the database
            $sqlImage = "UPDATE payment_details SET image_path = ? WHERE appointment_id = ?";
            $stmtImage = $conn->prepare($sqlImage);
            $stmtImage->bind_param('si', $imagePath, $appointmentId);
            
            if ($stmtImage->execute()) {
                echo "Image uploaded successfully.";
            } else {
                echo "Error uploading image.";
            }
            $stmtImage->close();
        } else {
            echo "Error uploading image.";
        }
    }
}

$stmtAmount->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Payment Page</title>
</head>
<body>
<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
        <li><a href="index.php">Home</a></li>
        <li><a href="appointment.php">Book</a></li>
        <li><a href="contact.php">Contact</a></li>
        <script>
            function confirmLogout() {
                var result = confirm("Are you sure you want to logout?");
                if (result) {
                    window.location.href = "logout.php";
                }
            }
        </script>
        <?php if(!isset($_SESSION["username"])): ?>
            <li><a href="login.php">Login</a></li>
        <?php else: ?>
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        <?php endif; ?>
    </ul>
    <div class="clearfix"></div>
</header>

<div class="payment-container">
    <h2>Payment Details</h2>
    <p>Amount to Pay: RM<?php echo number_format($amountToPay, 2); ?></p>
    
    <div>
        <p>Scan the QR code to make the payment:</p>
        <a href="qrpayment.php">
            <img src="images/IMG_9194.jpg" alt="QR Code" id="qrCode" style="cursor: pointer;" width="200px">
        </a>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <input type="hidden" name="appointment_id" value="<?php echo $appointmentId; ?>">
            <input type="hidden" name="id" value="<?php echo $customerId; ?>">
            <label for="receipt">Upload Receipt:</label>
            <input type="file" id="receipt" name="receipt" required>
        </div>
        <div>
            <input type="submit" value="Submit Receipt">
        </div>
    </form>

    <div>
        <a href="index.php">Back</a>
    </div>
</div>

</body>
</html>

