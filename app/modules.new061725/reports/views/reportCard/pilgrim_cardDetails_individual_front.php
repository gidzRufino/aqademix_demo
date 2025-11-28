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
$resolution= array(230, 297);
$pdf->AddPage('L', $resolution);

$total_pdays =0;
$total_adays =0;
$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$uccp = K_PATH_IMAGES.'/uccp.jpg';

$student = Modules::run('registrar/getSingleStudent', $st_id, $sy);
$shStrand = Modules::run('subjectmanagement/getStrandCode', $student->strnd_id); 

$principal = Modules::run('hr/getEmployeeByPosition', 'High School Principal');
$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0, 1).'. '.$principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL,  $sy, $student->section_id);
$adv = strtoupper($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0, 1).'. '.$adviser->row()->lastname);
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid,1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid,2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid,3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid,4, $sy);




//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('mdY',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->temp_bdate;
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[0];
    $d = $bdateItems[1];
    $y = $bdateItems[2];
    $thisYearBdate = $m.$d.$settings->school_year;
    $now = $settings->school_year;
    $age = abs($now - $y);
    
    if(abs($thisYearBdate>$firstFridayOfJune)){
        $yearsOfAge = $age - 1;
    }else{
        $yearsOfAge = $age;
    }

//
////start of the left column
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetY(20);
$pdf->MultiCell(148, 0, 'Report on Attendance',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(10);
$pdf->SetX(5);
$pdf->MultiCell(20, 10, '',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    endif;
    $pdf->MultiCell(10, 10,date("M",mktime(0,0,0,$m,1,2000)) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}

$pdf->MultiCell(10, 10, 'Total',1,'C' , 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(20, 10, 'No. of School Days',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$sd = Modules::run('reports/getRawSchoolDays', $sy, 4);
$pdf->MultiCell(10, 10, $sd->row()->June, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->July, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->August, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->September, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->October, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->November, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->December, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->January, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->February, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->March, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 10, $sd->row()->April, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$totalDays = $sd->row()->June+$sd->row()->July + $sd->row()->August + $sd->row()->September + $sd->row()->October + $sd->row()->November + $sd->row()->December + $sd->row()->January + $sd->row()->February + $sd->row()->March + $sd->row()->April;
$pdf->MultiCell(10, 10, $totalDays, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(5);
$pdf->MultiCell(20, 10, 'No. of Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$year = $sy;

$sRec1 = Modules::run('sf10/getSPRrec', $student->st_id, $sy, 1, $student->grade_level_id);
$attendancePresent1 = Modules::run('sf10/getAttendanceOveride',$sRec1->spr_id, $sy);
$sRec2 = Modules::run('sf10/getSPRrec', $student->st_id, $sy, 2, $student->grade_level_id);
$attendancePresent2 = Modules::run('sf10/getAttendanceOveride',$sRec2->spr_id, $sy)->row();
//
$pdf->MultiCell(10, 10, ($attendancePresent1 ? $attendancePresent1->row()->June : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent1 ? $attendancePresent1->row()->July : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent1 ? $attendancePresent1->row()->August : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent1 ? $attendancePresent1->row()->September : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent1 ? $attendancePresent1->row()->October : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent2 ? $attendancePresent2->November : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent2 ? $attendancePresent2->December : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent2 ? $attendancePresent2->January : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent2 ? $attendancePresent2->February : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent2 ? $attendancePresent2->March : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(10, 10, ($attendancePresent2 ? $attendancePresent2->April : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$totalDaysPresent = ($attendancePresent2 ? $attendancePresent1->row()->June + $attendancePresent1->row()->July + $attendancePresent1->row()->August + $attendancePresent1->row()->September + $attendancePresent1->row()->October + $attendancePresent2->November + $attendancePresent2->December + $attendancePresent2->January + $attendancePresent2->February + $attendancePresent2->March + $attendancePresent2->April : 0);
$pdf->MultiCell(10, 10, $totalDaysPresent, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->Ln(40);


$pdf->MultiCell(148, 0, 'PARENT / GUARDIAN\'S SIGNATURE',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(30, 10, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, '1st Quarter:', 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);
$pdf->MultiCell(30, 10, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, '2nd Quarter:', 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);
$pdf->MultiCell(30, 10, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(20, 10, '3rd Quarter:', 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);
$pdf->MultiCell(30, 10, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(20, 10, '4th Quarter:', 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');


//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);



$x = 150;
$pdf->SetXY($x, 8);
$pdf->setX($x);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(139.7, 7, "REPUBLIC OF THE PHILIPPINES",0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(4);
$pdf->SetX($x);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(139.7, 7, "DEPARTMENT OF EDUCATION",0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(6);
$pdf->SetTextColor(0, 73, 9);
$pdf->SetX($x);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->MultiCell(139.7, 7, strtoupper($settings->set_school_name),0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);
$pdf->SetX($x);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(139.7, 7, strtoupper('United Church of Christ in the Philippines'),0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(3);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX($x);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(139.7, 7, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
$pdf->Ln(6);
$pdf->SetX($x);
$pdf->SetFont('Times', 'B', 12);
$pdf->MultiCell(139.7, 7, "SENIOR HIGH SCHOOL",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
$pdf->Ln(5);
$pdf->SetX($x);
$pdf->SetFont('Times', 'B', 12);
$pdf->MultiCell(139.7, 7, "REPORT CARD",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
$pdf->Ln(5);
$pdf->SetX($x);
$pdf->SetFont('Times', 'B', 10);
$pdf->MultiCell(139.7, 7, "FORM 138-A",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
$pdf->Ln(10);
$pdf->SetX($x + 5);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(139.7, 7, "ACSCU-AAI Accredited Level II", 0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
$pdf->Ln(8);

$pdf->SetX($x+5);
$pdf->SetFont('Times', 'N', 9);
$pdf->MultiCell(12, 5, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(117, 3, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetX($x+5);
$pdf->MultiCell(9, 5, 'Age:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$bday = new DateTime($student->temp_bdate); // Your date of birth
$today = new Datetime('today');
$diff = $today->diff($bday);
$pdf->MultiCell(10, 5, $diff->y,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, 'Sex:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 3, 'LRN:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(68, 3, $student->lrn,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX($x+5);
$pdf->MultiCell(12, 5, 'Grade:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32 , 3, substr($student->level, 5, 3),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Section:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 3, $student->section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetX($x+5);
$pdf->MultiCell(21, 5, 'School Year:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22 , 3, $settings->school_year.' - '.($settings->school_year+1),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(21, 5, 'Track/Strand:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(65, 3, $shStrand->strand,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->SetFont('helvetica', 'B', 7);
$pdf->Ln(10);
$pdf->SetX($x+5);
$pdf->MultiCell(0, 0, 'Dear Parent:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);
$pdf->SetX($x+15);
$pdf->Cell(0,0,'This report card shows the ability and progress of your child has made in different learning areas',0,0,'L');
$pdf->Ln(3);
$pdf->SetX($x+5);
$pdf->Cell(0,0,'as well as his/her core values. ',0,0,'L');
$pdf->Ln(1);
$pdf->SetX($x+15);
$pdf->Cell(0,10,'This school welcomes you should you desire to know more about your child\'s progress.',0,0,'L');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln(20);
$pdf->SetX(155);
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $name, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $adv, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(10, 5, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Teacher', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$x = 155;
$pdf->Ln(8);
$pdf->SetX($x);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(148, 0, 'Certificate of Transfer',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);  
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX($x);
$pdf->MultiCell(50, 5, 'Eligible for Transfer and Admission to :', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 3, urldecode(segment_7), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(13, 5, 'Date:', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, urldecode(date('F d, Y', strtotime(segment_8))), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
//$pdf->SetX(155);
//$pdf->MultiCell(45, 5, 'Eligibility for Admission To :', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(85, 5, urldecode(segment_6), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->Ln(5);
$pdf->SetX(155);
$pdf->MultiCell(0, 5, 'Approved:', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);
$pdf->SetX(155);
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $name, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $adv, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(10, 5, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Teacher', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(155);  
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(148, 0, 'Cancellation of Eligibility to Transfer',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);    
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(155);  
$pdf->MultiCell(28, 5, 'Admitted to Grade:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5); 
$pdf->SetX(155);   
$pdf->MultiCell(10, 5, 'Date:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5); 
$pdf->SetX(155);     
$pdf->MultiCell(70 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 6);
$pdf->Ln(8);
$pdf->SetX(165);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Image($image_file, 160, 13, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($uccp, 265 , 13, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Line(148, 5, 148, 1, array('color' => 'black'));


//back page



$pdf->AddPage();
$data['student'] = $student;
$data['gradeLevel'] = $gradeLevel;
$data['sy'] = $sy;
$data['term'] = $term; 
$data['behaviorRate'] = $behavior; 
$data['bh_group'] = $bh_group;
$data['pdf'] = $pdf;
$data['sem'] = $sem;
$data['settings'] = $settings;
$data['shStrand'] = $shStrand;
$data['student_id'] = $student_id;
$this->load->view('reportCard/pilgrim_cardDetails_individual_back', $data);

//Close and output PDF document
ob_end_clean();
$pdf->Output($student->lastname.', '.substr($student->firstname, 0, 1).'_DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+