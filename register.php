    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<script>
    function validateForm() {
        var fullname = document.forms["registrationForm"]["fname"].value.trim();
        var email = document.forms["registrationForm"]["email"].value.trim();
        var phone = document.forms["registrationForm"]["phone"].value.trim();
        var address = document.forms["registrationForm"]["address"].value.trim();
        var username = document.forms["registrationForm"]["username"].value.trim();
        var password = document.forms["registrationForm"]["password"].value.trim();
        var carmodel = document.forms["registrationForm"]["carmodel"].value.trim();
        var carplate = document.forms["registrationForm"]["carplate"].value.trim();
        var role = document.forms["registrationForm"]["role"].value.trim();
        var create_datetime = document.forms["registrationForm"]["create_datetime"].value.trim();

        var errorMessage = "";

        if (fname === "" || email === "" || phone === "" || address === "" || username === "" || password === "" || carmodel === "" || carplate === "" || role === "" || create_datetime === "") {
            errorMessage += "Please fill out all the information before submitting.\n";
        }

        if (password.length < 8) {
            errorMessage += "Password must be at least 8 characters\n";
        }

        if (!/[0-9]/.test(password)) {
            errorMessage += "Password must contain at least one number\n";
        }

        if (errorMessage !== "") {
            alert(errorMessage);
            return false;
        }

        return true;
    }
</script>

<?php
// Include your database connection code here (the $con variable)
require('db.php');

// When the form is submitted, insert values into the database
if (isset($_REQUEST['username'])) {
    // Remove backslashes and escape special characters
    $fname = stripslashes($_POST['fname']);
    $fname = mysqli_real_escape_string($conn, $fname);

    $phonenum = stripslashes($_POST['phonenum']);
    $phonenum = mysqli_real_escape_string($conn, $phonenum);

    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($conn, $email);

    $address = stripslashes($_POST['address']);
    $address = mysqli_real_escape_string($conn, $address);

    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($conn, $username);

    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);

    $carmodel = stripslashes($_POST['carmodel']);
    $carmodel = mysqli_real_escape_string($conn, $carmodel);

    $carplate = stripslashes($_POST['carplate']);
    $carplate = mysqli_real_escape_string($conn, $carplate);

    $create_datetime = date("Y-m-d H:i:s");

    // Insert data into the 'customers' table
    $query1 = "INSERT INTO `customers` (fname, phonenum, email, address, username, password, carmodel, carplate, create_datetime)
              VALUES ('$fname', '$phonenum', '$email', '$address', '$username', '" . md5($password) . "', '$carmodel', '$carplate', '$create_datetime')";

    $query2 = "INSERT INTO `car_details` (username, carplate, carmodel, carcolor, carmileage, description)
              VALUES ('$username', '$carplate', '$carmodel', '', 0, '')"; 

$result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    if ($result1 && $result2) {
        // Show a popup form
        echo "<script>
                function closePopup() {
                    window.location.href = 'index.php'; // Redirect to homepage
                }
              </script>
              <div id='popupForm' style='display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999;'>
                  <div style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #f1f1f1; padding: 20px; border-radius: 5px;'>
                      <h3>You are registered successfully.</h3>
                      <p>Click here to <a href='login.php'>Login</a>.</p>
                      <button onclick='closePopup()'>Close</button>
                  </div>
              </div>";
    } else {
        echo "<div class='form'>
              <h3>Required fields are missing.</h3><br/>
              <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
              </div>";
    }
} else {
?>

<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
        <ul class="navlist">
    
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="appointment.php">Book</a>
                        </li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                        <li>
                            <a href="review.php">Reviews</a>
                        </li>

    <script>
            function confirmLogout() {
                var result = confirm("Are you sure you want to logout?");
                if (result) {
                    window.location.href = "logout.php";
                }
            }
    </script>
                        
                        <?php if(!isset($_SESSION["username"])):?>
                        <li>
                        <a href="login.php">Login</a>
                        </li>
                        <?php else:?>
                       
                        <li>
                               <a href="#" onclick="confirmLogout()">Logout</a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>
    
                <div class="clearfix"></div>
            </div>
            <div class="header-icons">
                <a href="track.php"><i class='bx bx-map'></i></a>
                <a href="cart.php"><i class='bx bx-shopping-bag'></i></a>
                <div class="bx bx-menu" id="menu-icon"></div>
            </div>
    </header><br><br>
 
    <div class="register-container">
        <h2>REGISTER</h2>
        <form class="form" action="" method="post" name="registrationForm" onsubmit="return validateForm()">

        <?php if(isset($errorMessage)): ?>
        <?php echo $errorMessage; ?>
        <?php endif; ?>

            <label for="fname">Full Name:</label>
            <input type="text" id="fname" name="fname" required>

            <label for="phonenum">Phone Number:</label>
            <input type="tel" id="phonenum" name="phonenum" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="address">Address:</label>
            <textarea name="address" required></textarea>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="carmodel">Car Model:</label>
            <input type="text" id="carmodel" name="carmodel" required>

            <label for="carplate">Car Plate:</label>
            <input type="text" id="carplate" name="carplate" required>

            <input type="submit" name="submit" value="Register" class="reg-button"><br>
            <button type="reset" value="Reset">Reset</button><br>

            <br><p>Already have account ?</p>
            <a href="login.php">Login</a>

        </form>
        <p id="error-message"></p>
        </div> 
</body>
</html>

<?php } ?>