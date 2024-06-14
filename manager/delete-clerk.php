<?php
// Include database connection file
include 'db.php';

// Check if 'id' is provided in the URL
if (isset($_GET["id"])) {
    // Prepare a delete statement
    $sql = "DELETE FROM clerk WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {

        // Set parameters
        $param_id = $_GET["id"];

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_id);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Record deleted successfully. Redirect to landing page
            header("location: manage-clerk.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    // If no 'id' parameter in URL, do error handling or redirection
    // Redirect to error page or display an error message
    echo "Error: No id value found.";
}

// Close connection
mysqli_close($conn);
?>
