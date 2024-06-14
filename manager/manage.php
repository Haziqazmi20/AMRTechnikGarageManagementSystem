<?php
session_start();
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=devie-width">
        <title>Login</title>
        <link rel="stylesheet" href="adminstyle.css">
    </head>
<body>
<header>
<a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
    <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage</a></li>
        <li><a href="task.php">Task</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="servicehistory.php">Service History</a></li>
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

    <div class="dashboard">
        <h3>Manage Employee</h3>
        <a href="manage-mechanic.php"><button>Manage Mechanic</button></a>
        <a href ="manage-clerk.php"><button>Manage Clerk</button></a>
    </div>

    <script src="script.js"></script>

</body>
</html>