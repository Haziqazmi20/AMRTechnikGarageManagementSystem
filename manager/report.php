<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
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
            <li><a href="servicedetails.php">Service</a></li>
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        </ul>
    </header>

    <div class="dashboard">
        <h2>Generate Report</h2>
        <form action="generate_report.php" method="GET">
            <label for="report_type">Select Report Type:</label>
            <select name="report_type" id="report_type" required>
                <option value="item">Item Report</option>
                <option value="task">Task Report</option>
                <option value="payment">Customer Payment Report</option>
            </select>
            <button type="submit">Generate Report</button>
        </form>
    </div>

    <script>
        function confirmLogout() {
            var result = confirm("Are you sure you want to logout?");
            if (result) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>
</html>
