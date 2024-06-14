<?php
session_start();
include('db.php');

// Check if task ID and status are provided
if (!isset($_POST['task_id']) || !isset($_POST['status'])) {
    header("Location: task.php");
    exit();
}

// Get the task ID and status from the POST request
$taskId = $_POST['task_id'];
$status = $_POST['status'];

// Update the status of the task in the database
$sql = "UPDATE tasks SET status = '$status' WHERE id = $taskId";
if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "Task status updated successfully";
} else {
    $_SESSION['error'] = "Error updating task status: " . $conn->error;
}

// Redirect back to the task page
header("Location: task3.php");
exit();
?>