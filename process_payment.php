<?php
require('db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the payment details from the form
    $cardNumber = mysqli_real_escape_string($conn, $_POST['cardNumber']);
    $streetAddress = mysqli_real_escape_string($conn, $_POST['streetAddress']);
    $addressDetails = mysqli_real_escape_string($conn, $_POST['addressDetails']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zipCode = mysqli_real_escape_string($conn, $_POST['zipCode']);
    
    // Retrieve the user ID and the most recent appointment ID for this user
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM customers WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $customer = mysqli_fetch_assoc($result);
        $customerId = $customer['id'];
    } else {
        die("Customer not found");
    }

    $sql = "SELECT id FROM appointments WHERE customerName = '$username' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $appointment = mysqli_fetch_assoc($result);
        $appointmentId = $appointment['id'];
    } else {
        die("Appointment not found");
    }

    // Insert the payment details into the payments table
    $sql = "INSERT INTO payments (appointment_id, customer_id, card_number, street_address, address_details, city, state, zip_code)
            VALUES ('$appointmentId', '$customerId', '$cardNumber', '$streetAddress', '$addressDetails', '$city', '$state', '$zipCode')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Payment processed successfully.";
        // Optionally, redirect to a confirmation page
        // header("Location: confirmation.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>