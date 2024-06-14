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


<body>
<!-- main content -->
<div class="wrapper">

		<div class="row">
			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-primary">
					<p>
						<i class="fas fa-users"></i>
					</p>
					<h3>Total Customer</h3>
				</div>
			</div>
			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-hat-cowboy"></i>
					</p>
					<h3>Total Mechanic</h3>
				</div>
			</div>
			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-success">
					<p>
						<i class="fas fa-spinner"></i>
					</p>
					<h3>Total Appointment</h3>
				</div>
			</div>
			
		</div>


		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3 style="color:red; text-align:center" >Recent Enquiry By Customer
						</h3>
					</div>

					<div class="card-content">
						<table>
							<thead>
								<tr>
									<th>Appointment ID</th>
									<th>Customer Name</th>
									<th>Date</th>
									<th>Time</th>
									<th>Services</th>
									<th>Addtional Service</th>
								</tr>
							</thead>
							<tbody>
								<tr>
                            <?php
                                $sql = "SELECT id, customerName, preferredDate, preferredTime, service, addService FROM appointments";

                                 // Execute the query using mysqli_query
                                $result = mysqli_query($conn, $sql);
                                     if (mysqli_num_rows($result) > 0) {
                                     // Fetch each row from the result set
                                    while($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["customerName"]; ?></td>
                                    <td><?php echo $row["preferredDate"]; ?></td>
                                    <td><?php echo $row["preferredTime"]; ?></td>
                                    <td><?php echo $row["service"]; ?></td>
                                    <td><?php echo $row["addService"]; ?></td>
                    
								</tr>
							</tbody>
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
				</div>
			</div>
		</div>
</div>
</body>
</html>