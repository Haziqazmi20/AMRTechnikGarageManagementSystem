<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];

        // Prepare the delete statement
        $delete_sql = "DELETE FROM appointments WHERE id = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("i", $task_id);

        if ($stmt_delete->execute()) {
            echo "Task deleted successfully.";
        } else {
            echo "Error: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    } else {
        echo "Task ID is not set.";
    }
}

$conn->close();
?>