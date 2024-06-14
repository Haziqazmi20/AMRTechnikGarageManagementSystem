<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mech_id = $_POST['Mech_id'];
    $cust_id = $_POST['Custid'];
    $service = $_POST['service'];
    $carmodel = $_POST['carmodel'];
    $carmileage = $_POST['carmileage'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $username = $_POST['username']; // Add username field

    // Retrieve the appointment ID based on the customer ID
    $appointment_sql = "SELECT id FROM appointments WHERE id = '$cust_id' AND status = 'accepted'";
    $appointment_result = $conn->query($appointment_sql);

    if ($appointment_result->num_rows > 0) {
        $appointment_row = $appointment_result->fetch_assoc();
        $appointment_id = $appointment_row['id'];

        // Insert the new task into the tasks table
        $insert_sql = "INSERT INTO tasks (mechanic_id, appointment_id, carmodel, carmileage, date, time, username)
                       VALUES ('$mech_id', '$appointment_id', '$carmodel', '$carmileage', '$date', '$time', '$username')"; // Add username field

        if ($conn->query($insert_sql) === TRUE) {
            // Update the appointment status to 'assigned'
            $update_sql = "UPDATE appointments SET status = 'assigned' WHERE id = '$appointment_id'";
            $conn->query($update_sql);

            // Redirect to the assigned tasks page
            header("Location: task3.php");
            exit();
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    } else {
        echo "No accepted appointment found with the provided customer ID.";
    }

    $conn->close();
}
?>


<?php
// Close the database connection
mysqli_close($conn);
?>
