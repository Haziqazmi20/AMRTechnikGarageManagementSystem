<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "amrtechnik";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];

    // Insert data into the users table
    $sql = "INSERT INTO clerk (id, username, password, name, phone) VALUES ('$id', '$username', '" . md5($password) . "', '$name', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! Click <a href='manage-clerk.php'>here</a> to view table";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();