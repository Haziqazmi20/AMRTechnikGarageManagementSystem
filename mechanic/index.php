<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMR TECHNIK TASK</title>
    <link rel="stylesheet" href="mechstyle.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }
        header {
            background: #fff;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            text-align: center;
        }
        .navlist {
            list-style: none;
            padding: 0;
        }
        .navlist li {
            display: inline;
            margin: 0 10px;
        }
        .navlist a {
            text-decoration: none;
            color: #333;
        }
        .task-container {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        .task-card {
            background: #fff;
            padding: 20px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .task-card h3 {
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .task-info {
            margin-bottom: 10px;
        }
        .task-info span {
            font-weight: bold;
        }
        .timer {
            padding: 10px 0;
            text-align: center;
            background: #ddd;
            margin-bottom: 10px;
        }
        .complete-btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            background: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
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
                        <a href="task.php">Task</a>
                    </li>
                    <li>
                        <a href="servicerec.php">Record</a>
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
</header>

<div class="task-container">
    <div class="task-card">
        <h3>MECHANIC: AMIRUL</h3>
        <div class="task-info">
            <span>OWNER:</span> LOK<br>
            <span>CAR MODEL:</span> BMW<br>
            <span>CAR PLATE:</span> VMB829
        </div>
        <div class="timer">
            TIMER:<br>
            30:00
        </div>
        <button class="complete-btn">COMPLETE</button>
    </div>

    <div class="task-card">
        <h3>Last Date Serviced:</h3>
        <div class="task-info">
            15/11/2023
        </div>
        <h3>Service Details:</h3>
        <div class="task-info">
            Engine oil x 1: RM50.00
        </div>
        <div class="task-info">
            <span>Total RM 50.00</span>
        </div>
        <h3>New Service</h3>
        <div class="task-info">
            Date: 20/12/2023
        </div>
        <div class="task-info">
            Engine oil x 1: RM50.00
        </div>
        <div class="task-info">
            <span>Total RM 50.00</span>
        </div>
    </div>
</div>

</body>
</html>