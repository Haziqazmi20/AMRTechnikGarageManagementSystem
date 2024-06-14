<?php 
require('db.php');
session_start();

if (isset($_POST['submit'])) {
    $filter_id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
    $id = mysqli_real_escape_string($conn, $filter_id);
    $filter_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $username = mysqli_real_escape_string($conn, md5($filter_username));
    $filter_pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));

    $select_users = mysqli_query($conn, "SELECT * FROM `clerk` WHERE id = '$id' AND username = '$username' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        if ($row['username'] == $username) {
            $_SESSION['clerk'] = $row['username'];
            header('location:inventory.php');
        } else {
            $message[] = 'no user found!';
        }
    } else {
        $message[] = 'incorrect username or password!';
        echo "<script>document.addEventListener('DOMContentLoaded', function() { showPopupForm(); });</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=devie-width">
        <title>Login</title>
        <link rel="stylesheet" href="clerkstyle.css">
        
    </head>
<body>

        <div class="login-container">
          
          <h1>AMR TECHNIK GARAGE</h1><br>
            <!--login form-->
            <h2>LOGIN CLERK</h2>
            <form id="logform" action="index.php" method="post">

                <label for="id">ID number : </label>
                <input type="text" id="id" name="id" required>

                <label for="username">Username : </label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password : </label>
                <input type="password" id="password" name="password">

                <input type="submit" value="Login" name="submit"/><br>

            </div>
            </form>
            <p id="error-message"></p>
        </div>
        
        <script src="script.js"></script>
        
    </body>
</html>