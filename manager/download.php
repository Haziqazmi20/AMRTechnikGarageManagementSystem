<?php
// Get the file path from the query parameter
$file = $_GET['file'];

// Define the path to the folder containing the files
$folder = 'C:/xampp/htdocs/AMRTechnik/images/';

// Combine the folder path and the file name to get the full path
$filepath = $folder . $file;

// Check if the file exists
if (file_exists($filepath)) {
    // Set appropriate headers
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    // Read the file and output it to the browser
    readfile($filepath);
    exit;
} else {
    // File not found
    echo 'File not found.';
}
?>
