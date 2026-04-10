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

$pdf->setTitle($task->task_title);

$pdf->AddPage('P', '');
$pdf->Ln();

$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);


// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
$pdf->SetFont('helvetica', 'B', 8);
if($this->session->st_id != null):
    $student = Modules::run('opl/student/getStudent', $this->session->st_id);
    $pdf->MultiCell(75, 5, "Name: ".$student->firstname." ".$student->lastname, '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(230, 5, "Grade and Section: ".$student->level." - ".$student->section, 'B', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');   
    $pdf->Ln(10);
endif;
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, $task->task_title, '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->WriteHtml($task->task_details, true, false, true, false, '');
$pdf->Output($task->task_title.'.pdf', 'I');