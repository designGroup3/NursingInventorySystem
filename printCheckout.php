<?php

require('vendor/setasign/fpdf/fpdf.php');

include 'dbh.php';

class PDF extends FPDF {
// Page header
    function Header()
    {
        $this->SetFont('Arial','',9);
        $this->Cell(185,12,'Print Date: '.date('m/d/Y'),0,1,'R');

        $this->SetFont('Arial','B',12);
        $this->Cell(60, 5, "UMSL College of Nursing",0,1,'C');

        $this->SetFont('Arial','',10);
        $this->Cell(36, 5, "1 University Blvd.",0,1,'C');
        $this->Cell(65, 5, "162 Nursing Administration Building",0,1,'C');
        $this->Cell(42, 5, "St. Louis, MO 63121",0,1,'C');
        $this->Cell(44, 5, "Phone: 314-516-6755",0,1,'C');
        $this->Ln(2);
        $this->Cell(5, 1, "",0,0,'C');
        $this->Cell(180, 0, "",1,1,'C');
    }
}

$id = $_GET['Id'];

// Body
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',17);
$pdf->Cell(60,13,'Checkout Receipt',0,1, 'C');

$result = mysqli_query($conn, "SELECT Person, Item, `Quantity Borrowed`, `Checkout Date`, `Due Date`, Reason FROM checkouts WHERE Id = ".$id);
while($row = mysqli_fetch_array($result)) {

    //Borrower Name
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(67, 10, 'Borrower Name:', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(-20, 0, "", 0, 0, 'L');
    $pdf->Cell(0, 10, $row['Person'], 0, 1, 'L');

    //Borrower Signature
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(61, 10, 'Borrower Signature:', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(64, 10, '__________________________________________', 0, 1, 'C');

    //Item
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(84, 8, 'Item:', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(-37, 0, "", 0, 0, 'L');
    $pdf->Cell(0, 8, $row['Item'], 0, 1, 'L');

    //Quantity
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(78, 8, 'Quantity:', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(-58, 8, $row['Quantity Borrowed'], 0, 1, 'C');

    //Checkout Date
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(68, 8, 'Checkout Date:', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    $date = date_create($row['Checkout Date']);
    $pdf->Cell(-21, 8, date_format($date, 'm/d/Y'), 0, 1, 'C');

    //Due Date
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(77, 8, 'Due Date:', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    $date = date_create($row['Due Date']);
    $pdf->Cell(-39, 8, date_format($date, 'm/d/Y'), 0, 1, 'C');

    //Actual Check-in Date
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(59, 8, 'Actual Check-in Date:', 0, 0, 'C');
    $pdf->SetFont('Times', 'I', 12);
    $pdf->Cell(93, 8, '__________________________________________ (mm/dd/yyyy)', 0, 1, 'C');

    //Reason
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(80, 10, 'Reason:', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(-33, 0, "", 0, 0, 'L');
    $pdf->Cell(0, 10, $row['Reason'], 0, 1, 'L');

    //Notes
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(25, 10, 'Notes:', 0, 1, 'C');
    $pdf->Ln(7);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(190, 8, '__________________________________________________________________________________', 0, 1, 'C');
    $pdf->Cell(190, 8, '__________________________________________________________________________________', 0, 1, 'C');
    $pdf->Cell(190, 8, '__________________________________________________________________________________', 0, 1, 'C');
    $pdf->Cell(190, 8, '__________________________________________________________________________________', 0, 1, 'C');
    $pdf->Cell(190, 8, '__________________________________________________________________________________', 0, 1, 'C');
}

$pdf->Output();
?>