<?php
require('db.php');
if (isset($_GET['token']) && isset($_POST['password'])) {
    $token = $_GET['token'];
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM `customers` WHERE reset_token='$token' AND reset_token_expiry > NOW()";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $hashed_password = md5($password);
        $query = "UPDATE `customers` SET password='$hashed_password', reset_token=NULL, reset_token_expiry=NULL WHERE reset_token='$token'";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Password has been reset successfully.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Failed to reset password.'); window.location.href='reset_password.php?token=$token';</script>";
        }
    } else {
        echo "<script>alert('Invalid or expired token.'); window.location.href='forgot_password.php';</script>";
    }
} elseif (isset($_GET['token'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Reset Password</title>
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
    <h1>Reset Password</h1><br>
    <form id="reset-password-form" action="reset_password.php?token=<?php echo $_GET['token']; ?>" method="post">
        <label for="password">New Password: </label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Reset Password">
    </form>
</div>
</body>
</html>
<?php } else {
    header("Location: forgot_password.php");
}
?>
