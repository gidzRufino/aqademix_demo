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

$totalDays =0;;
$total_pdays =0;
$total_adays =0;
$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
$division_logo = K_PATH_IMAGES.'/division_logo.jpg';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0, 1).'. '.$principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL,  $sy, $student->section_id);
$adv = strtoupper($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0, 1).'. '.$adviser->row()->lastname);
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid,1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid,2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid,3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid,4, $sy);


//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('mdY',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->cal_date;
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


//start of the left column
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetY(20);
$pdf->MultiCell(148, 0, 'Report on Attendance',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(10);
$pdf->SetX(8);
$pdf->MultiCell(25, 10, '',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for($d=1;$d<=10;$d++){
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
$pdf->SetX(8);
$pdf->MultiCell(25, 10, 'No. of School Days',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for($d=1;$d<=10;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    else:
        $schoolYear = $sy;
    endif;
    
    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    $pdf->MultiCell(10, 10,$totalDaysInAMonth ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}

$pdf->MultiCell(10, 10, $totalDays,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(25, 10, 'No. of Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for($d=1;$d<=10;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    else:
        $schoolYear = $sy;
    endif;
    
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
            else:    
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
            endif;
     if($pdays>$totalDaysInAMonth):
         $pdays = $totalDaysInAMonth;
     endif;
     
     $pdf->MultiCell(10, 10, $pdays,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
         
    $total_pdays += $pdays;
    $pdays = 0;
}


$pdf->MultiCell(10, 10, $total_pdays,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(25, 10, 'No. of Days Absent',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$tardy = 0;
for($d=1;$d<=10;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    else:
        $schoolYear = $sy;
    endif;
    
    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
            else:    
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
            endif;
            
     if($pdays>$totalDaysInAMonth):
         $pdays = $totalDaysInAMonth;
     endif;
    
     $pdf->MultiCell(10, 10, ($totalDaysInAMonth-$pdays),'BR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
         
    $total_adays += ($totalDaysInAMonth-$pdays);
    $pdays = 0;
}
$pdf->MultiCell(10, 10, $total_adays,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(40);


$pdf->MultiCell(148, 0, 'PARENT / GUARDIAN\'S SIGNATURE',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(30, 10, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, '1st Quarter:',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->MultiCell(30, 10, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, '2nd Quarter:',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->MultiCell(30, 10, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(20, 10, '3rd Quarter:',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->MultiCell(30, 10, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(20, 10, '4th Quarter:',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(50, 10, '','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');


//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);



$pdf->SetFont('helvetica', 'N', 5);
$pdf->SetXY(155, 3);
$pdf->MultiCell(85, 0, 'DepED Form 138-A',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(50, 0, 'LRN:  '.$student->st_id,0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetXY(155, 10);
$pdf->SetFont('helvetica', 'B', 10);
// Title Right Side Column
$pdf->MultiCell(0, 0, 'Republic of the Philippines',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(0, 0, 'Department of Education',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(0, 0, 'Region '.$settings->region,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(0, 0, 'Division of '.$settings->division,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetX(159);
$pdf->MultiCell(15, 5, 'School',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110, 5, strtoupper($settings->set_school_name),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(159);
$pdf->MultiCell(15, 5, 'Name',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110 , 5, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(159);
$pdf->MultiCell(15, 5, 'Age',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $yearsOfAge,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Sex',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(37 , 5, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(159);
$pdf->MultiCell(15, 5, 'Grade',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $student->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Section',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(37 , 5, $student->section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$next = $sy + 1;

$pdf->Ln(10);
$pdf->SetX(155);
$pdf->MultiCell(0, 5, $sy.' - '.$next,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(165);
$pdf->MultiCell(40, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 0, 'School Year','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 8);
$pdf->Ln(10);
$pdf->SetX(165);
$pdf->MultiCell(0, 0, 'Dear Parents,',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);
$pdf->SetX(185);
$pdf->Cell(0,0,'This report card shows the ability and progress of your child has made in ',0,0,'L');
$pdf->Ln(5);
$pdf->SetX(165);
$pdf->Cell(0,0,'different learning areas as well as his/her core values. ',0,0,'L');
$pdf->Ln(5);
$pdf->SetX(165);
$pdf->Cell(0,10,'This school welcomes you should you desire to know more about your child\'s progress.',0,0,'L');

$pdf->Ln(10);
$pdf->SetX(148);
$pdf->MultiCell(90, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $adv,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(148);
$pdf->MultiCell(90, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 0, 'Teacher','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(5);
$pdf->SetX(165);
$pdf->MultiCell(50, 5, $name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(165);
$pdf->MultiCell(50, 0, 'Principal','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(8);
$pdf->SetX(155);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(148, 0, 'Certificate of Transfer',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);  
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(155);  
$pdf->MultiCell(28, 5, 'Admitted To Grade:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(14 , 5, 'Section',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);  
$pdf->SetX(155);  
$pdf->MultiCell(0, 5, 'Eligibility for Admission To Grade:________________________________________________',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);    
$pdf->SetX(155);
$pdf->MultiCell(0, 5, 'Approved:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);    
$pdf->SetX(155);
$pdf->MultiCell(10 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();    
$pdf->SetX(155);
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, 'Teacher',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(155);  
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(148, 0, 'Cancellation of Eligibility to Transfer',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);    
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(155);  
$pdf->MultiCell(28, 5, 'Admitted To Grade:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5); 
$pdf->SetX(155);   
$pdf->MultiCell(10, 5, 'Date:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5); 
$pdf->SetX(155);     
$pdf->MultiCell(70 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50 , 5, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 6);
$pdf->Ln(8);
$pdf->SetX(165);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Image($image_file, 165, 15, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($division_logo, 265 , 15, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
$this->load->view('newReportCard/reportCardSecondPage', $data);

//Close and output PDF document
ob_end_clean();
$pdf->Output($student->lastname.', '.substr($student->firstname, 0, 1).'_DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+