<?php
$pdf->SetXY($x, $y);
$pdf->MultiCell(96.5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Courier', 'N', 6);
$pdf->MultiCell(65, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(30, 7, date('F d, Y'),0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Courier', 'N', 6);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(30, 7, 'Payment Type:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Courier', 'N', 6);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(30, 7, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Courier', 'N', 6);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(30, 7, 'Grade Level:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Courier', 'N', 6);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(30, 7, 'SY:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln(5);

$pdf->SetX($x+10);
$pdf->SetFont('Courier', 'N', 6);
$pdf->MultiCell(6, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(45, 7, 'Description:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(25, 7, '10,000.00',0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
