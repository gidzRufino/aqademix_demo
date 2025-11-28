<?php
$semester = Modules::run('main/getSemester');

if($sem==NULL):
    $sem = $semester;
endif;

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('college/getSingleStudent', $st_id, $school_year, $sem);
$next = $school_year + 1;


$image_file = K_PATH_IMAGES.'/pilgrim.jpg';
$pdf->Image($image_file, 55, 3, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$image_file = K_PATH_IMAGES.'/uccp.jpg';
$pdf->Image($image_file, 143, 3, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetXY(0, 5+$x);
$pdf->SetFont('helvetica', 'B', 15);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(216, 0, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(6);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(216, 0, 'United Church of Christ in the Philippines',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);
$pdf->SetX(0);
$pdf->MultiCell(216, 0, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(216, 0, '(088) 856 - 4239 local 606',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->MultiCell(216, 0,'CERTIFICATE OF REGISTRATION',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

//basic info
$pdf->Ln(8);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(42, 0, $student->uid,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, strtoupper($student->lastname),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, strtoupper($student->firstname),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, strtoupper(substr($student->middlename, 0,1)),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
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
$pdf->MultiCell(20, 0, 'Subject Code',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(70, 0, 'Descriptive Title',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, 'Unit/s',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Day',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, 'Time',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Room',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(35, 0, 'Instructor',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $student->semester, $school_year);

$totalUnits = 0;
$totalLab = 0;
foreach ($loadedSubject as $sl):
    $totalUnits += ($sl->sub_code=="NSTP 11" || $sl->sub_code=="NSTP 12" || $sl->sub_code=="NSTP 1" || $sl->sub_code=="NSTP 2" ? 3 :($sl->s_lect_unit+$sl->s_lab_unit));
    
    if ($sl->sub_lab_fee_id != 0):
        $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
        $totalLab += $itemCharge->default_value;
    endif;
endforeach;

foreach ($loadedSubject as $sl):
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->MultiCell(20, 0, $sl->sub_code,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(70, 0, $sl->s_desc_title,1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(10, 0, ($sl->sub_code=="NSTP 11" || $sl->sub_code=="NSTP 12" || $sl->sub_code=="NSTP 1" || $sl->sub_code=="NSTP 2" ? 3 :($sl->s_lect_unit+$sl->s_lab_unit)),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    
    $scheds = Modules::run('college/schedule/getSchedulePerSection', $sl->cl_section, $student->semester, $school_year); 
    $sched = json_decode($scheds);
    $instructor = Modules::run('collegel/schedule/getInstructorPerSchedule', $sched->sched_code);
    
    $pdf->MultiCell(20, 0, ($sched->count > 0 ? $sched->day:'TBA'),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(30, 0, ($sched->count > 0 ? $sched->time:'TBA'),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, ($sched->count > 0 ? ($sched->room==""?'TBA':$sched->room):'TBA'),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(35, 0,  strtoupper($sched->instructor),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln();
    
endforeach;
    $pdf->SetX(5);
    $pdf->MultiCell(20, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(70, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(10, 0, $totalUnits,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(15, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(30, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(38, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(30, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln();
if($sl->sub_code=="NSTP 11" || $sl->sub_code=="NSTP 12" || $sl->sub_code=="NSTP 1" || $sl->sub_code=="NSTP 2"):
    $totalUnits = $totalUnits - 1.5;   
endif;


$plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
$tuition = Modules::run('college/finance/getChargesByCategory',1, $student->semester, $student->school_year, $plan->fin_plan_id );
$misc = Modules::run('college/finance_pilgrim/getOtherFees',$student->year_level, $student->school_year, $student->semester, $plan->fin_plan_id, $totalUnits, count($loadedSubject));
//$misc = Modules::run('college/finance/getChargesByItemId',2, $student->semester, $student->school_year, $plan->fin_plan_id );
$lab = Modules::run('college/finance/getLaboratoryFee',$student->uid, $student->semester, $student->school_year);
//$lab = Modules::run('college/finance/getChargesByCategory',3, $student->semester, $student->school_year, $plan->fin_plan_id, $student->uid);
$other = Modules::run('college/finance/getChargesByCategory',4, $student->semester, $student->school_year, $plan->fin_plan_id, $student->uid);

$discounts = Modules::run('college/finance/getDiscountsByItemId', $student->uid, $student->semester, $student->school_year);
//$totalDiscount = ($tuition->row()->amount*$totalUnits) * $discounts->disc_amount;
$totalDiscount = ($discounts->disc_type==0?($tuition->row()->amount*$totalUnits) * $discounts->disc_amount:$discounts->disc_amount);

$totalFees = (($tuition->row()->amount*$totalUnits)+$misc+$totalLab) - $totalDiscount;
$prelim = $totalFees * .25;
$midTerm = $totalFees * .25;
$semi = $totalFees * .25;
$final = $totalFees * .25;

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(100, 0, 'STATEMENT OF ACCOUNT',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(30, 0, 'Tuition Fee',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format(($tuition->row()->amount*$totalUnits),2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Prelim',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($prelim,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(30, 0, 'Other Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format($misc,2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Midterm',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($midTerm,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(30, 0, 'Laboratory Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format($totalLab,2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Semi Final',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($semi,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, strtoupper($this->session->name),'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(5, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'JOY M. CASIÑO','B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');


$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(30, 0, 'Optional Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, (number_format(0,2,'.',',')),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Final',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, number_format($final,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'ENCODED BY',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(5, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'REGISTRAR',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(30, 0, 'Discount()',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, number_format($totalDiscount,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(30, 0, 'Total Fees',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(30, 0, number_format(($totalFees),2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(25, 0, '',1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');



