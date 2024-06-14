<?php
require('db.php');
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch name from the database
$carModel = $_SESSION['username'];
$sql = "SELECT * FROM `customers` WHERE username = '$carModel'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $carModel = mysqli_fetch_assoc($result);
    $carMo = $carModel['carmodel']; // Replace 'name' with the actual column name in your admin table
} else {
    // Handle the case where admin data is not found
    $carMo = ""; // Set a default name
}

$carPlate = $_SESSION['username'];
$sql = "SELECT * FROM `customers` WHERE username = '$carPlate'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $carPlate = mysqli_fetch_assoc($result);
  $carPl = $carPlate['carplate']; // Replace 'name' with the actual column name in your admin table
} else {
  // Handle the case where admin data is not found
  $carMo = ""; // Set a default name
}

$username = $_SESSION['username'];

$sql = "SELECT tasks.*, appointments.*, tasks.status as tasks_status, services.payment_status as payment_status
        FROM tasks
        INNER JOIN appointments ON tasks.appointment_id = appointments.id
        INNER JOIN services ON tasks.appointment_id = services.appointment_id
        WHERE tasks.username = '$username'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>AMRTechnik</title>
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
        <?php if(!isset($_SESSION["username"])):?>
        <li><a href="login.php">Login</a></li>
        <?php else:?>
        <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        <?php endif;?>
    </ul>
</header>

<div class="dashboard">
    <h2>Customer Car</h2><br>
    <div class="car-details">
        <h3>Car Details</h3>
        <p><strong>Model:</strong> <?php echo $carMo; ?></p>
        <p><strong>Plate:</strong> <?php echo $carPl; ?></p>
        <a href="vehicleDetails.php"><button>Car Details</button></a>
        <a href="service_history.php"><button>Car History</button></a>
    </div><br><br>

    <div class="appointment-details">
        <h3>Appointment Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Customer Name</th>
                    <th>Car Plate</th>
                    <th>Car Model</th>
                    <th>Service Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['customerName']); ?></td>
                            <td><?php echo htmlspecialchars($row['carplate']); ?></td>
                            <td><?php echo htmlspecialchars($row['carmodel']); ?></td>
                            <td><?php echo htmlspecialchars($row['service']); ?></td>
                            <td><?php echo htmlspecialchars($row['preferredDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['preferredTime']); ?></td>
                            <td><?php echo htmlspecialchars($row['tasks_status']); ?></td>
                            <td>
                                <?php if($row['payment_status'] == 'pending'): ?>
                                    <form action="qrpayment.php" method="post">
                                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                                        <input type="submit" value="Pay Now">
                                    </form>
                                <?php elseif($row['payment_status'] == 'paid'): ?>
                                    Paid
                                <?php else: ?>
                                    Not available
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9">No appointments found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div><br>

    <a href="appointment.php"><button>Book Appointment</button></a>
</div><br>

<script src="script.js"></script>
</body>
</html>



<style>
.base-timer {
  position: relative;
  width: 100px;
  height: 100px;
}

.base-timer__svg {
  transform: scaleX(-1);
}

.base-timer__circle {
  fill: none;
  stroke: none;
}

.base-timer__path-elapsed {
  stroke-width: 7px;
  stroke: grey;
}

.base-timer__path-remaining {
  stroke-width: 7px;
  stroke-linecap: round;
  transform: rotate(90deg);
  transform-origin: center;
  transition: 1s linear all;
  fill-rule: nonzero;
  stroke: currentColor;
}

.base-timer__path-remaining.green {
  color: rgb(65, 184, 131);
}

.base-timer__path-remaining.orange {
  color: orange;
}

.base-timer__path-remaining.red {
  color: red;
}

.base-timer__label {
  position: absolute;
  width: 100px;
  height: 100px;
  top: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}
</style>

<script>
const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "orange",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "red",
    threshold: ALERT_THRESHOLD
  }
};

const TIME_LIMIT = 20;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;

document.getElementById("app").innerHTML = `
<div class="base-timer">
  <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
      <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
      <path
        id="base-timer-path-remaining"
        stroke-dasharray="283"
        class="base-timer__path-remaining ${remainingPathColor}"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </g>
  </svg>
  <span id="base-timer-label" class="base-timer__label">${formatTime(
    timeLeft
  )}</span>
</div>
`;

startTimer();

function onTimesUp() {
  clearInterval(timerInterval);
}

function startTimer() {
  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(timeLeft);

    if (timeLeft === 0) {
      onTimesUp();
    }
  }, 1000);
}

function formatTime(time) {
  const minutes = Math.floor(time / 60);
  let seconds = time % 60;

  if (seconds < 10) {
    seconds = `0${seconds}`;
  }

  return `${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const { alert, warning, info } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(warning.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(alert.color);
  } else if (timeLeft <= warning.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(info.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(warning.color);
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
  document
    .getElementById("base-timer-path-remaining")
    .setAttribute("stroke-dasharray", circleDasharray);
}
</script>