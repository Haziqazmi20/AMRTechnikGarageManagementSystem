<?php
require('db.php');
if (isset($_POST['email'])) {
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($conn, $email);

    $query = "SELECT * FROM `customers` WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        // Generate a unique verification token
        $token = bin2hex(random_bytes(50));
        $query = "UPDATE `customers` SET reset_token='$token', reset_token_expiry=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email='$email'";
        if (mysqli_query($conn, $query)) {
            // Send reset email
            $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the link below to reset your password:\n$reset_link";
            $headers = "From: no-reply@yourdomain.com";
            mail($email, $subject, $message, $headers);
            echo "<script>alert('Password reset link has been sent to your email.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Email address not found.'); window.location.href='forgot_password.php';</script>";
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
        <li><a href="index.php">Home</a></li>
        <li><a href="appointment.php">Book</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="login.php">Login</a></li>
    </ul>
</header>
<div class="login-container">
    <h1>Forgot Password</h1><br>
    <form id="forgot-password-form" action="forgot_password.php" method="post">
        <label for="email">Email Address: </label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Reset Password">
    </form>
</div>
</body>
</html>
<?php } ?>
