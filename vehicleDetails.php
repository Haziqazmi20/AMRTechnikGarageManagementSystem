<?php
require('db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch car details from the database
$sql = "SELECT * FROM `car_details` WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$carDetails = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $carDetails[] = $row;
    }
} else {
    // Handle the case where no car details are found
    $carDetails = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AMR Technik</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function updateCarDetails() {
            var carSelect = document.getElementById('carSelect');
            var selectedCar = carSelect.value;
            var carDetails = <?php echo json_encode($carDetails); ?>;

            var carInfo = carDetails.find(car => car.carplate === selectedCar);
            if (carInfo) {
                document.getElementById('carModel').innerText = carInfo.carmodel;
                document.getElementById('carColor').innerText = carInfo.carcolor;
                document.getElementById('carMileage').innerText = carInfo.carmileage;
                document.getElementById('carDescription').innerText = carInfo.description;
            }
        }
    </script>
</head>
<body onload="updateCarDetails()">

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

<div class="dashboard-board">
    <h2>Customer Car</h2><br>
    <div class="car-details">
        <h3>Car Details</h3>
        <?php if (!empty($carDetails)): ?>
            <label for="carSelect">Select Car Plate:</label>
            <select id="carSelect" onchange="updateCarDetails()">
                <?php foreach ($carDetails as $detail): ?>
                    <option value="<?php echo htmlspecialchars($detail['carplate']); ?>"><?php echo htmlspecialchars($detail['carplate']); ?></option>
                <?php endforeach; ?>
            </select>

            <div id="carInfo">
                <p><strong>Car Model:</strong> <span id="carModel"></span></p>
                <p><strong>Car Color:</strong> <span id="carColor"></span></p>
                <p><strong>Car Mileage:</strong> <span id="carMileage"></span></p>
                <p><strong>Description:</strong> <span id="carDescription"></span></p>
            </div>
        <?php else: ?>
            <p>No car details found. <a href="vehicleRegister.php">Add Car Details</a></p>
        <?php endif; ?>
        <a href="vehicleRegister.php"><button>Edit Car Details</button></a>
        <a href="addCar.php"><button>Add New Car</button></a>
    </div><br><br>
    <a href="index.php"><button>Back</button></a>
</div>

</body>
</html>
