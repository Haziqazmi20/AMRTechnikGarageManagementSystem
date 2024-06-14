<body>
	
	<!----header section--->
	<header>
		<a href="index.php" class="logo">AMR TECHNIK GARAGE</a>

		<ul class="navlist">

                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="appointment.php">Book</a>
                    </li>
                    <li>
                        <a href="service.php">Services</a>
                    </li>
                    <li>
                        <a href="#contact">Contact</a>
                    </li>
                    <li>
                        <a href="review.php">Reviews</a>
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
                    <a href="login.html">Login</a>
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