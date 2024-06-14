<?php
session_start();
include('db.php');

// Initialize variables
$id = ""; $name =""; $phone = "";
$error_message = "";

// Check if 'id' is set in URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a select statement
    $sql = "SELECT id, name, phone FROM clerk WHERE id = ?";

    if($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement
        mysqli_stmt_bind_param($stmt, "s", $id);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1) {
                // Fetch result row as an associative array
                $row = mysqli_fetch_assoc($result);
                $name = $row["name"];
                $phone = $row["phone"];
                $id = $row["id"];
            } else {
                $error_message = "User not found.";
            }
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Oops! Something went wrong. Please try again later.";
    }
} else {
    $error_message = "User ID not specified.";
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Prepare an update statement
    $sql = "UPDATE clerk SET name = ?, phone = ? WHERE id = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        $param_name = $_POST["name"];
        $param_phone = $_POST["phone"];
        $param_id = $_POST["id"];

        mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_phone, $param_id);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records updated successfully. Redirect to landing page
            header("location: manage-mechanic.php");
            exit();
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Mechanic</title>
    <link rel="stylesheet" href="adminstyle.css">
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
		<div class="header-icons">
            <a href="track.php"><i class='bx bx-map'></i></a>
			<a href="cart.php"><i class='bx bx-shopping-bag'></i></a>
			<div class="bx bx-menu" id="menu-icon"></div>
		</div>
</header>
<body>
    <div class="update-container">
    <h2>Update clerk</h2>
    <?php if($error_message): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
        </div>
        <div>
            <label>Phone Number</label>
            <input type="text" name="phone" value="<?php echo $phone; ?>">
        </div>
        <div>
            <input type="submit" value="Update">
            <a href="manage-clerk.php">Cancel</a>
        </div>
    </form>
    </div>
</body>
</html>

</html>
