<?php
require('db.php');
session_start();

$username = "";
$carDetails = [];

// Check if user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch car details associated with the logged-in user
    $sql = "SELECT carplate, carmodel, carmileage, username FROM car_details WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $carDetails[] = $row;
        }
    }
} else {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carplate = $_POST["carplate"];
    $carmodel = $_POST["carmodel"];
    $carmileage = $_POST["carmileage"];
    $preferredDate = $_POST["preferredDate"];
    $preferredTime = $_POST["preferredTime"];
    $service = $_POST["service"];
    $addService = $_POST["addService"];
    $status = "pending"; // Set initial status

    $sql = "INSERT INTO appointments (customerName, carplate, carmodel, carmileage, preferredDate, preferredTime, service, addService, status)
            VALUES ('$username', '$carplate', '$carmodel', '$carmileage', '$preferredDate', '$preferredTime', '$service', '$addService', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment scheduled successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Appointment</title>
    <link rel="stylesheet" href="style.css">
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
            <?php if (!isset($_SESSION["username"])): ?>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <li><a href="#" onclick="confirmLogout()">Logout</a></li>
            <?php endif; ?>
        </ul>
        <div class="clearfix"></div>
    </header>

    <br>

    <div class="appointment-container">
        <div id="customerForm" class="form">
            <form id="appointmentForm" method="post" action="">
                <h3>Customer Appointment</h3>
                <label for="customerName">Name:</label>
                <input type="text" name="customerName" id="customerName" value="<?php echo $username; ?>" readonly>

                <label for="carplate">Car Plate:</label>
                <select id="carplate" name="carplate" required>
                    <?php foreach ($carDetails as $car): ?>
                        <option value="<?php echo $car['carplate']; ?>" data-carmodel="<?php echo $car['carmodel']; ?>" data-carmileage="<?php echo $car['carmileage']; ?>">
                            <?php echo $car['carplate']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="carmodel">Car Model:</label>
                <input type="text" name="carmodel" id="carmodel" readonly>

                <label for="carmileage">Car Mileage:</label>
                <input type="number" name="carmileage" id="carmileage" readonly>

                <label for="preferredDate">Preferred Date:</label>
                <input type="date" name="preferredDate" id="preferredDate" required>

                <label for="preferredTime">Preferred Time:</label>
                <input type="time" name="preferredTime" id="preferredTime" required step="1800">

                <label for="service">Type of Service:</label>
                <select id="service" name="service" required>
                    <option value="regular">Regular Service</option>
                    <option value="full">Full Service</option>
                    <option value="major">Major Service</option>
                </select><br><br>
                
                <label for="addService">Additional Service:</label>
                <input type="text" name="addService" id="addService">

                <div id="servinfo">
                    <table>
                        <thead>
                            <tr>
                                <th>Regular Service (~1-2 hours)</th>
                                <th>Full Service (~2-4 hours)</th>
                                <th>Major Service (~4-6 hours)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    - Oil change and filter replacement<br>
                                    - Serpentine belt inspection<br>
                                    - Wiper blade inspection<br>
                                    - Tire pressure checks
                                </td>
                                <td>
                                    - Engine air filter<br>
                                    - Cabin air filter<br>
                                    - Coolant<br>
                                    - Belts and hoses<br>
                                    - Brake pads
                                </td>
                                <td>
                                    - Brake fluid exchange<br>
                                    - Spark plug replacement<br>
                                    - Transmission fluid inspection (if applicable)<br>
                                    - Timing belt replacement (based on MSMS)<br>
                                    - Battery testing<br>
                                    - Tire replacement
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="submit">Schedule Appointment</button>
                <br><br><br>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('carplate').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var carModel = selectedOption.getAttribute('data-carmodel');
            var carMileage = selectedOption.getAttribute('data-carmileage');

            document.getElementById('carmodel').value = carModel;
            document.getElementById('carmileage').value = carMileage;
        });

        // PREFERRED TIME
        function roundTimeTo30Minutes(timeString) {
            var timeParts = timeString.split(':');
            var hours = parseInt(timeParts[0]);
            var minutes = parseInt(timeParts[1]);

            // Round minutes to the nearest 30-minute interval
            minutes = Math.round(minutes / 30) * 30;
            if (minutes == 60) {
                hours++;
                minutes = 0;
            }

            // Format hours and minutes
            var formattedHours = (hours < 10) ? '0' + hours : hours;
            var formattedMinutes = (minutes < 10) ? '0' + minutes : minutes;

            return formattedHours + ':' + formattedMinutes;
        }

        document.getElementById('preferredTime').addEventListener('change', function() {
            var selectedTime = this.value;
            var roundedTime = roundTimeTo30Minutes(selectedTime);
            this.value = roundedTime;
        });
    </script>
</body>
</html>
