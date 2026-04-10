<?php
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
    }

    // Page footer
    public function Footer() {
    }

}
// create new PDF document
$pdf = new MYPDF('P', 'mm', array('250', '400'), true, 'UTF-8', false);

$pdf->setTitle($discussion->dis_title);

$pdf->AddPage('P', '');
$pdf->Ln();

$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);


// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, $discussion->dis_title, '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->WriteHtml($discussion->dis_details, true, false, true, false, '');
$pdf->Output($discussion->dis_title.'.pdf', 'I');