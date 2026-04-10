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
$resolution= array(215.9, 280);
$pdf->AddPage('L', $resolution);

$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/lc_front.jpg';
$image_back = K_PATH_IMAGES.'/lc_back.jpg';
$image_back_bottom = K_PATH_IMAGES.'/lc_back_bottom.jpg';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal');
//$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0, 1).'. '.$principal->lastname);
$name = 'AMELIA D. BALOLOY';
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
//
//$pdf->SetFont('helvetica', 'B', 10);
////start of the left column
//$pdf->SetY(3);
//$pdf->MultiCell(148, 0, 'TEACHER\'S COMMENTS',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//
//
//
//$pdf->SetFont('helvetica', 'N', 10);
//$pdf->Ln(10);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'First Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, trim($first->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
//
//$pdf->Ln(10);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'Second Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, trim($second->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
//
//$pdf->Ln(10);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'Third Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, trim($third->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
//
//$pdf->Ln(10);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'Fourth Grading',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, trim($fourth->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
//
//
//$pdf->SetFont('helvetica', 'B', 10);
//$pdf->Ln(15);
//$pdf->MultiCell(148, 0, 'PARENT\'s SIGNATURE',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');    
//
//$pdf->SetFont('helvetica', 'N', 10);
//$pdf->Ln(10);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'First Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//
//$pdf->Ln(8);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'Second Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//
//$pdf->Ln(8);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'Third Grading:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//
//$pdf->Ln(8);
//$pdf->SetX(10);
//$pdf->MultiCell(30, 5, 'Fourth Grading',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

//$pdf->Image($image_back_bottom, 0, 83, 165, 126, 'JPG', '', 'T', FALSE, 100, '', false, false, 0, false, false, false);
$pdf->Image($image_back, 0, 0, 140, '', 'JPG', '', 'T', false, 100, '', false, false, 0, false, false, false);

$pdf->SetY(90);
$pdf->Setx(10);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(15);
$pdf->MultiCell(140, 0, 'CERTIFICATE FOR TRANSFER / ELIGIBILITY',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Setx(10);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln(15);    
$pdf->MultiCell(80, 5, 'Eligible for transfer and admission to Grade ',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Setx(10);
$pdf->Ln(15);    
$pdf->MultiCell(95, 5, 'Approved:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Setx(10);
$pdf->Ln(15);    
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 5, '',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, true, true, 5, 'M');
$pdf->MultiCell(10 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Setx(10);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln();    
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60 , 5, 'Adviser',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, 'Vice Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Setx(10);
$pdf->Ln(45); 
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(140, 5, strtoupper($settings->set_school_address),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Setx(10);
$pdf->Ln(); 
$pdf->MultiCell(140, 5, '433-0750 / 716-2762 | lifecollegepalawan@gmail.com | www.lifecollege.edu.ph',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

/*
$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln(20);
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
$pdf->MultiCell(60 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'N', 10);
$pdf->Ln();
$pdf->MultiCell(90 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60 , 5, 'Assistant Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
*/


// Title Right Side Colum
//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->SetX(145);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(140, 5, 'LRN : '.($student->lrn!=""?$student->lrn:$student->st_id),0, 'l', 0, 0, '', '', true, 0, false, true, 12, 'M');

$pdf->Image($image_file, 140, 0, 140, 150, 'JPG', '', 'T', false, 100, '', false, false, 0, false, false, false);

$pdf->SetXY(150, 127);
////$pdf->Cell(0,60,strtoupper($settings->set_school_name),0,0,'C');
//$pdf->MultiCell(140, 12, 'LIFECOLLEGE',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
//$pdf->Ln(6);
//$pdf->SetX(145);
//$pdf->SetFont('Courier', 'BI', 12);
//$pdf->MultiCell(140, 12, '(MOLDING CHAMPIONS)',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
//$pdf->SetFont('helvetica', 'B', 10);
//$pdf->Ln(8);
//$pdf->SetX(145);
//$pdf->MultiCell(140, 5, strtoupper($settings->set_school_address),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->Ln(4);
//$pdf->SetX(145);
//$pdf->MultiCell(140, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//
//
//$next = $sy + 1;
//$pdf->Ln(6);
//$pdf->SetX(145);
//$pdf->SetFont('HELVETICA', 'B', 12);
//$pdf->MultiCell(140, 12, $sy.' - '.$next,0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
//


$pdf->Ln();
$pdf->SetX(142);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('HELVETICA', 'B', 15);
$pdf->MultiCell(140, 12, 'STUDENT REPORT CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');

$pdf->SetTextColor(0,0,0);
$pdf->Ln(30);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX(142);
$pdf->MultiCell(15, 5, 'Name',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60 , 5, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'LRN' ,0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, ($student->lrn!=""?$student->lrn:$student->st_id),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(142);
$pdf->MultiCell(15, 5, 'Age',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $yearsOfAge,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Gender',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(142);
$pdf->MultiCell(15, 5, 'Grade',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $student->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
if($student->section==$student->level):
    $section = '';
else:
    $section = $student->section;
endif;
$pdf->MultiCell(15 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Section',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//
//$pdf->Ln(10);
//$pdf->SetX(171);
//$pdf->MultiCell(20, 5, 'Teacher:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(115 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//
//$pdf->Ln(10);
//$pdf->SetX(171);
//$pdf->MultiCell(35, 5, 'Assistant Principal:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(100 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 6);
$pdf->Ln(15);
$pdf->SetX(140);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');


//$pdf->Line(140, 5, 140, 1, array('color' => 'black'));


//back page



$pdf->AddPage();

$pdf->SetTextColor(0,0,0);
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