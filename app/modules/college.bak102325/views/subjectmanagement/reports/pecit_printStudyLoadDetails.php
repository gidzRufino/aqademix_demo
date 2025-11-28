<?php
$semester = Modules::run('main/getSemester');

if($sem==NULL):
    $sem = $semester;
endif;

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('college/getSingleStudent', $st_id, $school_year, $sem);
$next = $school_year + 1;

$pdf->SetXY(5,5+$x);
$pdf->SetFont('helvetica', 'B', 9);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(100, 0, $settings->set_school_name,0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'B', 17);
$pdf->SetXY(100,10+$x);
$pdf->MultiCell(110, 0,'CERTIFICATE OF REGISTRATION',0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->SetXY(100,16+$x);
$pdf->MultiCell(110, 0,$copy,0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(-2);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(100, 0, $settings->set_school_address,0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(8);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(100, 0, '225 - 5543',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

//basic info
$pdf->Ln(12);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(42, 0, $student->uid,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, ucfirst($student->lastname),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, ucfirst($student->firstname),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, substr($student->middlename, 0,1),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, substr($student->sex, 0,1),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(42, 0, 'ID Number',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Last Name',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'First Name',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'M.I.',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Gender',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

switch ($student->year_level):
    case 1:
        $year_level = '1st';
    break;
    case 2:
        $year_level = '2nd';
    break;
    case 3: 
        $year_level = '3rd';
    break;
    case 4:
        $year_level = '4th';
    break;
    case 5:
        $year_level = '5th';
    break;    
endswitch;

switch($student->semester):
    case 1:
        $sem = '1st';
    break;
    case 2:
        $sem = '2nd';
    break;
    case 3:
        $sem = 'Summer';
    break;
endswitch;

//basic info
$pdf->Ln();
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(42, 0, $student->short_code,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, $year_level,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, $school_year.' - '. $next,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, $sem,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, date('F d, Y | G:i:s'),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(42, 0, 'Course',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Year',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'School Year',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Semester',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(7);
$pdf->SetX(0);
$pdf->MultiCell(216, 0, '','T', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(20, 0, 'Sub Code',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(63, 0, 'Subject',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, 'Unit/s',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Day',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, 'Time',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Room',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, 'Instructor',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, 'Section',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id);

$totalUnits = 0;
foreach ($loadedSubject as $sl):
    $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
endforeach;

foreach ($loadedSubject as $sl):
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->MultiCell(20, 0, $sl->sub_code,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(63, 0, $sl->s_desc_title,1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(10, 0, $sl->s_lect_unit,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    
    $scheds = Modules::run('college/schedule/getSchedulePerSection', $sl->cl_section); 
    $sched = json_decode($scheds);
    $instructor = Modules::run('college/schedule/getInstructorPerSchedule', $sched->sched_code, $school_year);
//    $timeItem = explode('-', $sched->time);
//    $timeFrom = date('G:ia', strtotime($timeItem[0]));
//    $timeTo = date('G:ia', strtotime($timeItem[1]));
    
    
    
    $pdf->MultiCell(15, 0, ($sched->count > 0 ? $sched->day:'TBA'),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(30, 0, ($sched->count > 0 ? $sched->time:'TBA'),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, ($sched->count > 0 ? $sched->room:'TBA'),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(30, 0,  $instructor->lastname.', '.$instructor->firstname.' ',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(18, 0, $sl->section,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln();
    
endforeach;
    $pdf->SetX(5);
    $pdf->MultiCell(20, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(63, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(10, 0, $totalUnits,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(15, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(30, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(38, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(30, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln();



$plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
$tuition = Modules::run('college/finance/getChargesByCategory',1, $student->semester, $student->school_year, $plan->fin_plan_id );
$misc = Modules::run('college/finance/getChargesByCategory',2, $student->semester, $student->school_year, $plan->fin_plan_id );
//$misc = Modules::run('college/finance/getChargesByItemId',30, $student->semester, $student->school_year, $plan->fin_plan_id );
$lab = Modules::run('college/finance/getLaboratoryFee',$student->uid, $student->semester, $student->school_year);
//$lab = Modules::run('college/finance/getChargesByCategory',3, $student->semester, $student->school_year, $plan->fin_plan_id, $student->uid);
$other = Modules::run('college/finance/getChargesByCategory',4, $student->semester, $student->school_year, $plan->fin_plan_id, $student->uid);

$discounts = Modules::run('college/finance/getDiscountsByItemId', $student->uid, $student->semester, $student->school_year);
//$totalDiscount = ($tuition->row()->amount*$totalUnits) * $discounts->disc_amount;
$totalDiscount = ($discounts->disc_type==0?($tuition->row()->amount*$totalUnits) * $discounts->disc_amount:$discounts->disc_amount);

$totalFees = (($tuition->row()->amount*$totalUnits)+$misc->row()->amount+$lab->row()->extra_amount+$other->row()->amount) - $totalDiscount;
$prelim = $totalFees * .32;
$midTerm = $totalFees * .28;
$semi = $totalFees * .22;
$final = $totalFees * .18;

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(110, 0, 'STATEMENT OF ACCOUNT',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(40, 0, 'Tuition Fee',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format($tuition->row()->amount*$totalUnits,2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Prelim',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($prelim,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(40, 0, 'Miscellaneous Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format($misc->row()->amount,2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Midterm',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($midTerm,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(40, 0, 'Laboratory Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format($lab->row()->extra_amount,2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Semi Final',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($semi,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(5, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');


$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(40, 0, 'Other Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format($other->row()->amount,2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Final',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($final,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'STUDENT',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(5, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'REGISTRAR',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(40, 0, 'Discount()',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, number_format($totalDiscount,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(40, 0, 'Total Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, number_format(($totalFees),2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');


