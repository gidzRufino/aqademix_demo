<?php
class MYPDF extends Pdf {
    //Page header
	public function Header() {

            $this->SetTitle('DepED Form 138-A');
            
        }

}

        
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
//$resolution= array(166, 200);
$resolution= array(210, 297);
$pdf->AddPage('L', $resolution);

$totalDays =0;
$total_pdays =0;
$total_adays =0;
$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/maclc.jpg';
$division_logo = K_PATH_IMAGES.'/division_logo.jpg';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0, 1).'. '.$principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL,  $sy, $student->section_id);
$adv = ucwords(strtolower($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0, 1).'. '.$adviser->row()->lastname));
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid,1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid,2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid,3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid,4, $sy);

$pdf->SetFont('Times', 'R', 10);
$msg = Modules::run('reports/sbeMsg');
$pdf->Ln(5);
$pdf->writeHTMLCell(120, '', '', $pdf->SetX(15), $msg, '', 1, 0, true, 'L', true);
$pdf->Ln();

$pdf->SetXY(10, 60);
$pdf->SetFont('Times', 'B', 10);
$pdf->MultiCell(15, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, 'HELEN L. NACUA','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(60, 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(15, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, 'School Administrator',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(60, 5, 'Adviser',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(7);

$pdf->SetFont('Times', 'IB', 10);
$pdf->SetTextColor(194,8,8);
$pdf->MultiCell(145, 5, 'Parent\'s Signature Over Printed Name',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(10);

$pdf->SetX(10);
$pdf->SetFont('Times', 'B', 10);
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(25, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '1st Grading',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(25, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '2nd Grading',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(10);

$pdf->SetX(10);
$pdf->MultiCell(45, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->SetX(10);
$pdf->MultiCell(140, 5, '3rd Grading',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(8);

$pdf->SetX(25);
$pdf->setFillColor(255, 193, 193);
$pdf->MultiCell(100, 50, '',1, 'C', 1, 0, '', '', true, 0, false, true, 50, 'B');

$pdf->SetXY(25,110);
$pdf->SetFont('Times', 'B', 10);
$pdf->MultiCell(100, 5, 'CERTIFICATE OF TRANSFER',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(6);

$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(65, 5, 'Eligible for Admission to',0 , 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Times', 'I', 10);
$pdf->MultiCell(12, 5, '(level)',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, '','B' , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(10);

$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(65, 5, '',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, $adv,'B' , 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->MultiCell(65, 5, '',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, 'Adviser',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(10);
$pdf->MultiCell(45, 5, 'Approved:',0 , 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->MultiCell(40, 5, '',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, 'HELEN L. NACUA','B' , 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->MultiCell(40, 5, '',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, 'School Administrator',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 10);
$pdf->MultiCell(145, 5, 'CANCELLATION OF ELIGIBILITY TO TRANSFER',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(9);

$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(30, 5, 'Admitted to',0 , 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Times', 'I', 10);
$pdf->MultiCell(12, 5, '(level)',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, '','B' , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(15, 5, 'Section',0 , 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, '','B' , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(15, 5, 'in',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->SetFont('Times', 'I', 10);
$pdf->MultiCell(25, 5, '(school)',0 , 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(52, 5, '','B' , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(6, 5, 'on',0 , 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Times', 'I', 10);
$pdf->MultiCell(11, 5, '(date)',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, '','B' , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(3, 5, '.',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(10);

$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(85, 5, '',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '','B' , 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->MultiCell(85, 5, '',0 , 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, 'School Administrator',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');



//start of right column
//$pdf->AddFont('Roboto','','Roboto-Bold.php');
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->Image(base_url() . 'images/forms/malclcBorder.png', 152, 9, 145, 200);

$pdf->SetFont('Times', 'I', 8);
$pdf->SetXY(155, 3);
$pdf->MultiCell(140, 5, 'Form 138-E',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetXY(172, 20);
$pdf->SetFont('Roboto', 'B', 18);
// Title Right Side Column
$pdf->SetTextColor(194,8,8);
$pdf->MultiCell(100, 20, 'MAMBAJAO ALLIANCE CHILD LEARNING CENTER, INC.',0, 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->Ln();
$pdf->SetX(172);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell(100, 5, '(Montessori Casa and Grade School)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(172);
$pdf->MultiCell(100, 5, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(60);

$pdf->SetX(193);
$pdf->setFillColor(205, 92, 92);
$pdf->MultiCell(60, 10, '',0, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->SetX(193);
$pdf->SetFont('Times', 'B', 12);
$pdf->SetTextColor(255,255,255);
$pdf->MultiCell(60, 10, 'PROGRESS REPORT CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$next = $sy + 1;
$pdf->SetFont('Roboto', 'B', 12);
$pdf->SetTextColor(194,8,8);
$pdf->SetX(193);
$pdf->MultiCell(60, 10, 'School Year ' . $sy.' - '.$next,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(20);

$pdf->SetX(170);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Helvetica', 'R', 10);
$pdf->MultiCell(13, 5, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(90, 5, ucwords(strtolower($student->firstname.' '. ($student->middlename != '' ? substr($student->middlename, 0, 1) . '.' : '' ) . ' ' .$student->lastname)),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(170);
$pdf->SetFont('Helvetica', 'R', 10);
$pdf->MultiCell(11, 5, 'LRN:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(28, 5, ($student->lrn == '' ? $student->st_id : $student->lrn),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('Helvetica', 'R', 10);
$pdf->MultiCell(13, 5, 'Grade:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(20, 5, $student->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('Helvetica', 'R', 10);
$pdf->MultiCell(11, 5, 'Sex:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(20, 5, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(170);
$pdf->SetFont('Helvetica', 'R', 10);
$pdf->MultiCell(25, 5, 'Class Adviser:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(78, 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Image($image_file, 200, 55, 45, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//$pdf->Image($division_logo, 265 , 15, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Line(148, 5, 148, 1, array('color' => 'black'));


//back page



$pdf->AddPage();
$data['student'] = $student;
$data['sy'] = $sy;
$data['term'] = $term; 
$data['behaviorRate'] = $behavior; 
$data['bh_group'] = $bh_group; 
$data['pdf'] = $pdf;
$data['settings'] = $settings;
$this->load->view('reportCard/maclc_individual_back', $data);

//Close and output PDF document
ob_end_clean();
$pdf->Output($student->lastname.', '.substr($student->firstname, 0, 1).'_DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+