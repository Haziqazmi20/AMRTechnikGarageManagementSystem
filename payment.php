<?php
    require('db.php');
    session_start();

    // Fetch appointment_id from the GET request
    $appointment_id = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;
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
        <?php if(!isset($_SESSION["username"])):?>
            <li><a href="login.php">Login</a></li>
        <?php else:?>
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        <?php endif;?>
    </ul>
</header>

<div class="payment-container">
    <h2>Payment Details</h2>
    <form action="process_payment.php" method="post">
        <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
        <div>
            <label for="cardNumber">Card Number</label>
            <input type="text" id="cardNumber" name="cardNumber" required>
        </div>
        <div>
            <label for="streetAddress">Street Address</label>
            <input type="text" id="streetAddress" name="streetAddress" required>
        </div>
        <div>
            <label for="addressDetails">Address Details</label>
            <input type="text" id="addressDetails" name="addressDetails">
        </div>
        <div>
            <label for="city">City</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div>
            <label for="state">State</label>
            <input type="text" id="state" name="state" required>
        </div>
        <div>
            <label for="zipCode">ZIP Code</label>
            <input type="text" id="zipCode" name="zipCode" required>
        </div>
        <div>
            <input type="submit" value="Submit Payment">
        </div>
        <div>
            <a href="qrpayment.php">
                <img src="http://pngimg.com/uploads/qr_code/qr_code_PNG25.png" alt="QR Code" id="qrCode" style="cursor: pointer;" width="50px" height="50px">
            </a>
        </div>
        <div>
            <a href="index.php">Back</a>
        </div>
    </form>
</div>
</body>
</html>
