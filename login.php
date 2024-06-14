<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require('db.php');
session_start();
// When form submitted, check and create user session.
if (isset($_POST['username'])) {
    $username = stripslashes($_REQUEST['username']);    // removes backslashes
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM `customers` WHERE username='$username' AND password='" . md5($password) . "'";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        $_SESSION['username'] = $username;
        // Redirect to user dashboard page
        header("Location: index.php");
    } else {
        echo "<script>showErrorMessage();</script>";
    }
} else {
?>
<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
        <li><a href="index.php">Home</a></li>
        <li><a href="appointment.php">Book</a></li>
        <li><a href="#contact">Contact</a></li>
        <div class="clearfix"></div>
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
<div class="login-container">
    <h1>AMR TECHNIK GARAGE</h1><br>
    <!--login form-->
    <h2>LOGIN</h2>
    <form id="logform" action="login.php" method="post">
        <label for="username">Username : </label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password : </label>
        <input type="password" id="password" name="password">
        <a href="forgot_password.php">Forgot Password</a>
        <input type="submit" value="Login" name="submit"/><br>
        <br><p>Don't have an account?</p>
        <a href="register.php">Register account</a>

    </form>
    <p id="error-message"></p>
</div>
<script src="script.js"></script>
</body>
</html>
<?php } ?>


