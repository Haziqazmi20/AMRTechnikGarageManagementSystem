<?php
require('db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carplate = stripslashes($_POST['carplate']);
    $carplate = mysqli_real_escape_string($conn, $carplate);

    $carmodel = stripslashes($_POST['carmodel']);
    $carmodel = mysqli_real_escape_string($conn, $carmodel);

    $carcolor = stripslashes($_POST['carcolor']);
    $carcolor = mysqli_real_escape_string($conn, $carcolor);

    $carmileage = stripslashes($_POST['carmileage']);
    $carmileage = mysqli_real_escape_string($conn, $carmileage);

    $description = stripslashes($_POST['description']);
    $description = mysqli_real_escape_string($conn, $description);

    // Insert new car details into the 'car_details' table
    $query = "INSERT INTO `car_details` (username, carplate, carmodel, carcolor, carmileage, description) 
              VALUES ('$username', '$carplate', '$carmodel', '$carcolor', '$carmileage', '$description')";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        echo "<script>alert('New car added successfully.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error adding new car. Please try again.');</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
        <li><a href="index.php">Home</a></li>
        <li><a href="appointment.php">Book</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="review.php">Reviews</a></li>
        <script>
            function confirmLogout() {
                var result = confirm("Are you sure you want to logout?");
                if (result) {
                    window.location.href = "logout.php";
                }
            }
        </script>
        <?php if (!isset($_SESSION["username"])): ?>
            <li><a href="login.php">Login</a></li>
        <?php else: ?>
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        <?php endif; ?>
    </ul>
    <div class="clearfix"></div>
    <div class="header-icons">
        <a href="track.php"><i class='bx bx-map'></i></a>
        <a href="cart.php"><i class='bx bx-shopping-bag'></i></a>
        <div class="bx bx-menu" id="menu-icon"></div>
    </div>
</header>

<div class="car-details">
    <h2>Add New Car</h2>
    <form action="" method="post">
        <label for="carplate">Car Plate:</label>
        <input type="text" id="carplate" name="carplate" required>

        <label for="carmodel">Car Model:</label>
        <input type="text" id="carmodel" name="carmodel" required>

        <label for="carcolor">Car Color:</label>
        <input type="text" id="carcolor" name="carcolor" required>

        <label for="carmileage">Car Mileage:</label>
        <input type="number" id="carmileage" name="carmileage" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <br>
        <button type="submit">Submit</button>
        <a href="index.php"><button type="button">Back</button></a>
    </form>
</div>

</body>
</html>
