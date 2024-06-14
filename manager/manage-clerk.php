<?php
session_start();
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminstyle.css">
    <title>Read</title>
</head>

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
</header>

<body>

<div class="manage-container"> 
<h2>MANAGE CLERK</h2>
<a href="registerclerk.php"><button>Add Clerk</button></a>
<br><table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
    <?php

        // The SQL query to fetch all records from the users table
        $sql = "SELECT id, name, phone FROM clerk";

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
            <td><a href="updateclerkform.php?id=<?php echo $row["id"]; ?>"><button>Update</button></a>
            <a href="deleteclerkform.php?matric=<?php echo $row["id"]; ?>"><button>Delete</button></a></td>
        </tr>
        

    <?php
                }   
            }
            else {
                echo "<tr><td colspan='3'>No users found</td></tr>";
            }
            // Close connection
            mysqli_close($conn);
    ?>
    </table>
        </div>
</body>
</html>