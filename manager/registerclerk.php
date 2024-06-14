<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, inital-scale">
        <link rel="stylesheet" href="adminstyle.css">
        <title>Register admin</title>
</head>
<header>
<a href="index.php" class="logo">AMR TECHNIK</a>
    <ul class="navlist">
    <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage</a></li>
        <li><a href="task.php">Task</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="servicedetails.php">Service</a></li>
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
</header>
<body>
<div class="reg-container">
    <form action="insertclerk.php" method="post">
    <h2>REGISTER MECHANIC</h2>
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" required><br>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" id="phone" required><br>
       
        <input type="submit" name="submit" value="Submit">

</div>
</form>
</body>
</html>