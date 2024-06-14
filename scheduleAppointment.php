<?php
// Establish a database connection (replace these values with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "amrtechnik";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customerName = $_POST["customerName"];
    $preferredDate = $_POST["preferredDate"];
    $preferredTime = $_POST["preferredTime"];
    $serviceType = $_POST["service"];
    $addService = $_POST["addService"];

    // Insert data into the database
    $sql = "INSERT INTO appointments (customeName, preferredDate, preferredTime, serviceType, addService)
            VALUES ('$customerName', '$preferredDate', '$preferredTime', '$serviceType', '$addService')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment scheduled successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
