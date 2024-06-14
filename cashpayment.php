<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue</title>
    <link rel="stylesheet" href="style.css">`
</head>
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
            </div>

            <div class="clearfix"></div>
        </div>
		<div class="header-icons">
            <a href="track.php"><i class='bx bx-map'></i></a>
			<a href="cart.php"><i class='bx bx-shopping-bag'></i></a>
			<div class="bx bx-menu" id="menu-icon"></div>
		</div>
	</header>
    <body>
        <div class="