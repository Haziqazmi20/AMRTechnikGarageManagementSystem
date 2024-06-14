<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=devie-width">
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
<body>

<?php
    require('db.php');
    session_start();

?>

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
                            <a href="#contact">Contact</a>
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

        <div class="contact-container">
          
          <h1>AMR TECHNIK GARAGE</h1><br>
           
            <h2>CONTACT</h2>
            
            <div class="info-container">
                <p><strong>PHONE NUMBER: </p>
                <p>0166160397</p><br>
                <p>LOCATION: </p>
                <p>No. 25 Jalan Saujana Indah 3, 
                    Taman Perindustrian Saujana Indah, 
                    40000 Shah Alam Selangor Darul Ehsan.</p>
            </div>
           
            <p id="error-message"></p>
        </div>
        
        <script src="script.js"></script>
        
    </body>
</html>


