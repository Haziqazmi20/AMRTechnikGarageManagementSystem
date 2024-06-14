<?php
session_start();
include('db.php');

// Check if appointment ID, mechanic ID, and username are provided
if (!isset($_POST['appointmentId']) || !isset($_POST['mechanicId']) || !isset($_SESSION['username'])) {
    header("Location: task.php");
    exit();
}

$appointmentId = $_POST['appointmentId'];
$mechanicId = $_POST['mechanicId'];
$username = $_SESSION['username'];

// Fetch appointment details based on the provided ID
$sqlAppointment = "SELECT * FROM appointments WHERE id = $appointmentId";
$resultAppointment = $conn->query($sqlAppointment);

if ($resultAppointment->num_rows == 0) {
    // If appointment not found, redirect back to task page
    header("Location: task.php");
    exit();
}

$appointment = $resultAppointment->fetch_assoc();

// Insert data into tasks table with the associated username
$sqlInsert = "INSERT INTO tasks (appointment_id, mechanic_id, username, carplate, carmodel, carmileage, service, date, time) 
              VALUES ($appointmentId, $mechanicId, '$username', '{$appointment['carplate']}', '{$appointment['carmodel']}', '{$appointment['carmileage']}', '{$appointment['service']}', '{$appointment['preferredDate']}', '{$appointment['preferredTime']}')";

if ($conn->query($sqlInsert) === TRUE) {
    // Task assigned successfully
    header("Location: task3.php");
    exit();
} else {
    // Error occurred
    echo "Error: " . $sqlInsert . "<br>" . $conn->error;
}

$conn->close();
?>
