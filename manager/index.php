<?php 

session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch admin name from the database
$username = $_SESSION['admin'];
$sql = "SELECT * FROM `admin` WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $adminData = mysqli_fetch_assoc($result);
    $adminName = $adminData['name']; // Replace 'name' with the actual column name in your admin table
} else {
    // Handle the case where admin data is not found
    $adminName = "Admin"; // Set a default name
}
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
            <?php if(!isset($_SESSION["admin"])):?>
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
</header>


    <div class="dashboard">
        <h1 id="name">Welcome, <?php echo $adminName; ?></h1>
        <a href="manage.php"><button id="manage">Manage Employee</button></a>
        <a href="task.php"><button id="task">Tasks</button>
        <a href="adminappointment.php"><button id="appointment">Appointments Requests</button>
        <a href="task3.php"><button id="cust">Update status</button>
        <a href="custDetails.php"><button id="cust">Customer Details</button>
        <button id="reportsBtn">Reports</button>
    </div>

    <script src="script.js"></script>

</body>
</html>