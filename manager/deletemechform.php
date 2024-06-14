<?php
    session_start();
    include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="adminstyle.css">
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

<body>
    <div class="delete-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
        <?php

        // The SQL query to fetch all records from the users table
        $sql = "SELECT id, name, phone FROM mechanic";

        // Execute the query using mysqli_query
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Fetch each row from the result set
            while($row = mysqli_fetch_assoc($result)) {
    
            ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["phone"]; ?></td>
                <td><a href="delete-mechanic.php?id=<?php echo $row["id"]; ?>"><button>Delete</button></a></td>
            </tr>
        
    
            <?php
                    }   
                }
                else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                // Close connection
                mysqli_close($conn);
            ?>
        </table>
        <div>
            <br><a href="manage-mechanic.php">Cancel</a>
        </div>
            </div>
        
    </body>
    </html>
