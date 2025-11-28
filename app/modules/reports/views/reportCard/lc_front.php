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

$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/lc.png';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal');
$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0, 1).'. '.$principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL,segment_4, $student->section_id);
$adv = strtoupper($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0, 1).'. '.$adviser->row()->lastname);
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid,1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid,2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid,3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid,4, $sy);


//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('Y-m-d',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->cal_date;
//    $from = new DateTime($bdate);
//    $to   = new DateTime($firstFridayOfJune);
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[1];
    $d = $bdateItems[2];
    $y = $bdateItems[0];
    
    if(abs(date('m')<$m)){
        $yearsOfAge  = ((date('Y') - date('Y',strtotime($bdate))))-1;
        
    }else{
        $yearsOfAge = (date('Y') - date('Y',strtotime($bdate)));
    }

$pdf->SetFont('helvetica', 'B', 10);
//start of the left column
$pdf->SetY(3);
$pdf->MultiCell(148, 0, 'TEACHER\'S COMMENTS',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');



$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln(10);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'First Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, trim($first->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->Ln(10);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Second Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, trim($second->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->Ln(10);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Third Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, trim($third->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->Ln(10);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Fourth Grading',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, trim($fourth->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');


$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(15);
$pdf->MultiCell(148, 0, 'PARENT\'s SIGNATURE',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');    

$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln(10);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'First Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(8);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Second Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(8);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Third Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(8);
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Fourth Grading',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(15);
$pdf->MultiCell(148, 0, 'CERTIFICATE TO TRANSFER',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln(15);    
$pdf->MultiCell(40, 5, 'Admitted to Grade',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(14 , 5, 'Section',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(8);    
$pdf->MultiCell(60, 5, 'Eligible for admission to Grade',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(12);    
$pdf->MultiCell(95, 5, 'Approved:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);    
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 5, '',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln();    
$pdf->MultiCell(15, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, 'Teacher',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln(15);
$pdf->MultiCell(65, 5, 'Cancellation of Eligibility to transfer',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);    
$pdf->MultiCell(30, 5, 'Admitted in',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, 'Date',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(15);
$pdf->MultiCell(90 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln();
$pdf->MultiCell(90 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->SetX(155);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(140, 5, 'LRN : '.$student->lrn,0, 'l', 0, 0, '', '', true, 0, false, true, 12, 'M');

$pdf->Image($image_file, 195, 14, 60, '', 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);

$pdf->SetXY(155, 0);
// Title Right Side Column
$pdf->Ln(75);
$pdf->SetX(155);
$pdf->SetFont('Courier', 'B', 25);
//$pdf->Cell(0,60,strtoupper($settings->set_school_name),0,0,'C');
$pdf->MultiCell(140, 12, 'LIFE COLLEGE',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(6);
$pdf->SetX(155);
$pdf->SetFont('Courier', 'BI', 12);
$pdf->MultiCell(140, 12, '(MOLDING CHAMPIONS)',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(8);
$pdf->SetX(155);
$pdf->MultiCell(140, 5, strtoupper($settings->set_school_address),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(140, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(155);
$pdf->SetFont('HELVETICA', 'B', 15);
$pdf->MultiCell(140, 12, 'REPORT CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');

$next = $sy + 1;
$pdf->Ln(6);
$pdf->SetX(155);
$pdf->SetFont('HELVETICA', 'B', 12);
$pdf->MultiCell(140, 12, $sy.' - '.$next,0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');



$pdf->Ln(25);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX(161);
$pdf->MultiCell(20, 5, 'Name :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110 , 5, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(161);
$pdf->MultiCell(20, 5, 'Age',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $yearsOfAge,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Gender',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(161);
$pdf->MultiCell(20, 5, 'Grade',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $student->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
if($student->section==$student->level):
    $section = '';
else:
    $section = $student->section;
endif;
$pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Section:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(161);
$pdf->MultiCell(20, 5, 'Teacher:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(161);
$pdf->MultiCell(20, 5, 'Principal:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 6);
$pdf->Ln(25);
$pdf->SetX(165);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->Line(148, 5, 148, 1, array('color' => 'black'));


//back page



$pdf->AddPage();
$data['student'] = $student;
$data['sy'] = $sy;
$data['term'] = $term; 
$data['pdf'] = $pdf;
$data['settings'] = $settings;
$data['behaviorRate'] = $behavior; 
$this->load->view('reportCard/'.strtolower($settings->short_name).'_back', $data);

//$pdf->Ln(10);
//$pdf->StartTransform();
//$pdf->Rotate(90);
//$pdf->Cell(0,0,'This is a sample data',1,1,'L',0,'');
//$pdf->StopTransform();
//Close and output PDF document
ob_end_clean();
$pdf->Output('DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+