<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Payment Success</title>
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
    <h2>Payment Successful</h2>
    <p>Your payment has been processed successfully. Thank you!</p>
    <a href="index.php"><button>Go to Home</button></a>
</div>

</body>
</html>
