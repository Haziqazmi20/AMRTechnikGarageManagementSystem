<?php
require('db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch car plates associated with the logged-in user
$sql = "SELECT carplate, carmodel FROM `car_details` WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$carDetails = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $carDetails[$row['carplate']] = $row['carmodel'];
    }
}

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

    // Update data in the 'car_details' table using carplate as the primary key
    $query = "UPDATE `car_details` SET carmodel = '$carmodel', carcolor = '$carcolor', carmileage = '$carmileage', description = '$description' WHERE carplate = '$carplate' AND username = '$username'";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        echo "<script>alert('Car details updated successfully.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error updating car details. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function updateCarModel() {
            var carPlateSelect = document.getElementById('carplate');
            var carModelInput = document.getElementById('carmodel');
            var selectedCarPlate = carPlateSelect.value;
            var carDetails = <?php echo json_encode($carDetails); ?>;

            carModelInput.value = carDetails[selectedCarPlate] || '';
        }
    </script>
</head>
<body onload="updateCarModel()">

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
    <h2>Car Details</h2>
    <form action="" method="post">
        <label for="carplate">Car Plate:</label>
        <select id="carplate" name="carplate" onchange="updateCarModel()" required>
            <?php foreach ($carDetails as $plate => $model): ?>
                <option value="<?php echo $plate; ?>"><?php echo $plate; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="carmodel">Car Model:</label>
        <input type="text" id="carmodel" name="carmodel" readonly>

        <label for="carcolor">Car Color:</label>
        <input type="text" id="carcolor" name="carcolor">

        <label for="carmileage">Car Mileage:</label>
        <input type="number" id="carmileage" name="carmileage">

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <br>
        <button type="submit">Submit</button>
        <a href="index.php" class="button">Back</a>
    </form>
</div>

</body>
</html>
