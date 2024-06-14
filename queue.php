<?php
    require('db.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        header {
            background-color: #f2f2f2;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navlist {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        .navlist li {
            padding: 0 20px;
        }
        .navlist li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .queue {
            text-align: center;
            margin-top: 50px;
        }
        .clock {
            font-size: 48px;
            margin: 20px 0;
        }
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            background-color: #f2f2f2;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

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
                        <a href="contact.php">Contact</a>
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
            

            <div class="clearfix"></div>
        </div>
</header>

<div class="queue-container">
    <h2>QUEUE</h2>
    <?php
        // Calculate and display waiting time based on the previous customer's service time
        $waitingTime = "00:00:00"; // Default waiting time if there is no previous customer

        // You should have a way to get the previous customer's service time from your database
        // Replace this with the actual query to fetch the previous customer's service time
        $previousServiceTime = "02:30:00"; // Example service time

        if ($previousServiceTime) {
            $waitingTime = calculateWaitingTime($previousServiceTime);
        }

        echo "<p><strong>Waiting Time:</strong> $waitingTime</p>";

        // Get the selected car problem from the form
        $carProblem = $_POST['role'] ?? ''; // Make sure to validate and sanitize user input

        // Calculate and display service time based on the selected car problem
        $serviceTime = calculateServiceTime($carProblem);

        echo "<p><strong>Service Time:</strong> $serviceTime</p>";

        // Helper function to calculate waiting time
        function calculateWaitingTime($previousServiceTime)
        {
            // Your logic to calculate waiting time goes here
            // For example, you can add a fixed time or use a dynamic calculation
            return "01:00:00"; // Example waiting time
        }

        // Helper function to calculate service time based on the selected car problem
        function calculateServiceTime($carProblem)
        {
            // Your logic to calculate service time based on the car problem goes here
            // For example, you can have a mapping of car problems to service times
            $serviceTimes = [
                'oil' => '00:30:00',
                'absorber' => '01:15:00',
                'wiper' => '00:45:00',
                'tire' => '01:30:00',
                'battery' => '01:00:00',
                'brake' => '01:45:00',
                'wheels' => '01:15:00',
            ];

            // Return the service time for the selected car problem or a default time
            return $serviceTimes[$carProblem] ?? '00:00:00';
        }
        ?>
    <div class="clock" id="app"></div>
    <p>SERVICE BY MECHANIC AMIRUL<br>NO. PHONE: 0198887273</p>
    <a href="payment.php"><button>Payment</button></a>
</div>

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