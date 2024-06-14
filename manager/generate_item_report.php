<?php
// Include TCPDF library
require_once('path/to/tcpdf/tcpdf.php');
include('db.php');

// Fetch item details for the report
$sqlItemReport = "
    SELECT inventory.itemname, SUM(service_items.quantity_used) AS total_quantity_used, 
           SUM(purchases.quantity) AS total_quantity_bought, 
           inventory.quantity AS current_quantity, 
           SUM(purchases.total_cost) AS total_cost
    FROM inventory
    LEFT JOIN service_items ON inventory.id = service_items.item_id
    LEFT JOIN services ON service_items.service_id = services.id
    LEFT JOIN purchases ON inventory.id = purchases.item_id
    GROUP BY inventory.id
";
$resultItemReport = mysqli_query($conn, $sqlItemReport);

// Create new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Item Report');
$pdf->SetSubject('Item Report');
$pdf->SetKeywords('Item, Report, PDF');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', 'B', 14);

// Title
$pdf->Cell(0, 10, 'Item Report', 0, 1, 'C');

// Line break
$pdf->Ln(10);

// Set font for table
$pdf->SetFont('helvetica', '', 12);

// Table headers
$pdf->Cell(40, 10, 'Item Name', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total Quantity Used', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total Quantity Bought', 1, 0, 'C');
$pdf->Cell(40, 10, 'Current Quantity', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total Cost', 1, 1, 'C');

// Fetch and display item details
while ($row = mysqli_fetch_assoc($resultItemReport)) {
    $pdf->Cell(40, 10, $row['itemname'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['total_quantity_used'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['total_quantity_bought'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['current_quantity'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['total_cost'], 1, 1, 'C');
}

// Close and output PDF
$pdf->Output('item_report.pdf', 'D');
