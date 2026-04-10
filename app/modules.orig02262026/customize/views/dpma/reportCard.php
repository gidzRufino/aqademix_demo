<?php
class MYPDF extends Pdf
{
    //Page header
    public function Header()
    {

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
$res = 25.4;
$pdf->setPageUnit('mm');
$resolution = array(8.5 * $res, 11 * $res);
$pdf->AddPage('P', $resolution);

$totalDays = 0;;
$total_pdays = 0;
$total_adays = 0;
$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES . 'DepEd-MATATAG.png';
$school_logo = K_PATH_IMAGES . '/dpma.png';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname . ' ' . substr($principal->middlename, 0, 1) . '. ' . $principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL,  $sy, $student->section_id);
$adv = strtoupper($adviser->row()->firstname . ' ' . substr($adviser->row()->middlename, 0, 1) . '. ' . $adviser->row()->lastname);
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid, 1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid, 2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid, 3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid, 4, $sy);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
$st_name = ucwords(strtolower($student->firstname . ' ' . ($student->middlename != '' ? substr($student->middlename, 0, 1) . '.' : '') . ' ' . $student->lastname));

function getDesc($val)
{
    if ($val >= 91 && $val <= 100):
        return 'A';
    elseif ($val >= 86 && $val <= 90):
        return 'P';
    elseif ($val >= 81 && $val <= 85):
        return 'AP';
    elseif ($val >= 75 && $val <= 80):
        return 'D';
    elseif ($val <= 74):
        return 'B';
    endif;
}
function getRating($behaviorRating)
{
    $rate = $behaviorRating->row()->rate;
    switch ($rate) {
        case 1:
            $star = 'NO';
            break;
        case 2:
            $star = 'RO';
            break;
        case 3:
            $star = 'SO';
            break;
        case 4:
            $star = 'AO';
            break;

        default:
            $star = '';
            break;
    }
    return $star;
}

function ordinal($number)
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13))
        return $number . 'th';
    else
        return $number . $ends[$number % 10];
}

//get the birthday and the age before first friday of june
$firstFridayOfJune = date('mdY',  strtotime('first Friday of ' . 'June' . ' ' . $settings->school_year));
$bdate = $student->temp_bdate;
$bdateItems = explode('-', $bdate);
$m = $bdateItems[1];
$d = $bdateItems[2];
$y = $bdateItems[0];
$thisYearBdate = $m . $d . $settings->school_year;
$now = $settings->school_year;
$age = abs($now - $y);

if (abs($thisYearBdate > $firstFridayOfJune)) {
    $yearsOfAge = $age - 1;
} else {
    $yearsOfAge = $age;
}

//--------- For Attendance ------------------------------------ //

$gs_start = date('m', strtotime($settings->bosy));
$gs_end = date('m', strtotime($settings->eosy));
$gsDays = Modules::run('reports/getRawSchoolDays', $sy, 2);
$sprDetails = Modules::run('sf10/getSPRrec', $student->st_id, $sy, NULL, $student->grade_id);
$pdays = Modules::run('sf10/getAttendanceOveride', $sprDetails->spr_id, $sprDetails->school_year, $student->st_id);


$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->SetFont('times', 'R', 12);
$pdf->MultiCell(0, 10, 'Republic of the Philippines', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->MultiCell(0, 10, 'DEPARTMENT OF EDUCATION', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->MultiCell(0, 10, 'Region XII', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->MultiCell(0, 10, 'City Schools Division of Koronadal', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetFont('roboto', 'B', 17);
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell(0, 10, $settings->set_school_name, 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetFont('times', 'R', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(0, 10, $settings->set_school_address, 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 25);
$pdf->MultiCell(0, 12, 'PROGRESS REPORT CARD', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(7);


$pdf->SetFont('times', 'I', 10);
switch (TRUE):
    case $student->grade_id >= 2 && $student->grade_id <= 4:
        $dd = '(Primary Department)';
        break;
    case $student->grade_id >= 5 && $student->grade_id <= 7:
        $dd = '(Intermediate Department)';
        break;
    case $student->grade_id >= 8 && $student->grade_id <= 11:
        $dd = '(Junior High School Department)';
        break;
endswitch;

$pdf->MultiCell(0, 10, $dd, 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetFont('times', 'B', 12);
$pdf->SetX(20);
$pdf->MultiCell(20, 6, 'Name:', 0, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(140, 6, $st_name, 'B', 'L', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetX(20);
$pdf->MultiCell(20, 6, 'Gender:', 0, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(50, 6, $student->sex, 'B', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(30, 6, 'Grade Level:', 0, 'R', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(50, 6, $student->level, 'B', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetX(20);
$pdf->MultiCell(30, 6, 'School Year:', 0, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(50, 6, $sy . ' - ' . ($sy + 1), 'B', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(20, 6, 'LRN:', 0, 'R', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(65, 6, $student->lrn, 'B', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln(10);

$pdf->SetFont('Times', 'I', 13);
$msg = Modules::run('customize/msgToParents');
$pdf->writeHTMLCell(167, '', '', $pdf->SetX(25), $msg, 0, 1, 0, true, 'M', true);
$pdf->Ln(-5);

$pdf->SetFont('Times', 'B', 12);
$pdf->SetX(105);
$pdf->MultiCell(85, 6, $adv, 'B', 'C', 0, 0, '', '', true, 0, false, true, 6, 'B');
$pdf->Ln();

$pdf->SetX(105);
$pdf->MultiCell(85, 6, 'Class Adviser', 0, 'C', 0, 0, '', '', true, 0, false, true, 6, 'T');
$pdf->Ln(3);

$pdf->SetX(20);
$pdf->MultiCell(75, 6, 'CHRISMORE P. CABELLO', 'B', 'C', 0, 0, '', '', true, 0, false, true, 6, 'B');
$pdf->Ln();

$pdf->SetX(20);
$pdf->MultiCell(75, 6, 'School Administrator', 0, 'C', 0, 0, '', '', true, 0, false, true, 6, 'T');
$pdf->Ln(10);

$pdf->SetX(15);
$pdf->SetFont('Times', 'B', 11);
$pdf->SetFillColor(30, 0, 0, 0);
$pdf->MultiCell(180, 5, 'CERTIFICATE OF TRANSFER', 0, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);

$cot = Modules::run('customize/certOfTrans', $st_name, $student->level, $sy);
$pdf->SetX(15);
$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(30, 5, 'The bearer', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(90, 5, $st_name, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'was admitted to grade', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, ($student->grade_id - 1), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(30, 5, 'School Year', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, $sy . ' - ' . ($sy + 1), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(75, 5, 'and is eligible for transfer or be admitted to', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Grade ' . $student->grade_id, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(30, 5, 'Issued on', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'day of', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, ',', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '.', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);

$pdf->SetFont('Times', 'B', 12);
$pdf->SetX(105);
$pdf->MultiCell(85, 6, 'ENGR. JOSELITO S. CABELLO', 'B', 'C', 0, 0, '', '', true, 0, false, true, 6, 'B');
$pdf->Ln();

$pdf->SetX(105);
$pdf->MultiCell(85, 6, 'School Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 6, 'T');
$pdf->Ln(9);

$pdf->SetFont('Times', 'B', 11);
$pdf->SetX(15);
$pdf->MultiCell(180, 5, 'REPORT ON ATTENDANCE', 0, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);

$pdf->SetX(15);
$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(35, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $monthName = date('M', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $pdf->MultiCell(13, 5, $monthName, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
endfor;
$pdf->MultiCell(15, 5, 'Total', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(35, 5, 'No. of School Days', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $pdf->MultiCell(13, 5, $gsDays->$monthName, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $totalDays += $gsDays->$monthName;
endfor;
$pdf->MultiCell(15, 5, $totalDays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(35, 5, 'No. of Days Present', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $sy);
    $holiday = Modules::run('calendar/holidayExist', $m, $sy);
    $totalDaysInAMonth = $totalDays - $holiday->num_rows();
    $pdf->MultiCell(13, 5, ($pdays ? $pdays->row()->$monthName : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $total_pdays += ($pdays ? $pdays->row()->$monthName : 0);
endfor;
$pdf->MultiCell(15, 5, $total_pdays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(35, 5, 'No. of times Absent', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $sy);
    $holiday = Modules::run('calendar/holidayExist', $m, $sy);
    $totalDaysInAMonth = $totalDays - $holiday->num_rows();
    $pdf->MultiCell(13, 5, ($gsDays->$monthName - ($pdays ? $pdays->row()->$monthName : 0)), 'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $total_adays += ($gsDays->$monthName - ($pdays ? $pdays->row()->$monthName : 0));
endfor;
$pdf->MultiCell(15, 5, $total_adays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('Times', 'B', 11);
$pdf->SetX(15);
$pdf->MultiCell(180, 5, 'PARENTS ACKNOWLEDGEMENT', 0, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('Times', 'I', 10);
$ackMsg = Modules::run('customize/ackMsg');
$pdf->writeHTMLCell(167, '', '', $pdf->SetX(22), $ackMsg, 0, 1, 0, true, 'M', true);
$pdf->Ln(3);

$pdf->SetFont('Times', 'R', 11);
$pdf->SetX(15);
$pdf->MultiCell(37, 5, 'FIRST QUARTER', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(37, 5, 'THIRD QUARTER', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(15);
$pdf->MultiCell(37, 5, 'SECOND QUARTER', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(37, 5, 'FOURTH QUARTER', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->Image($image_file, 145, 8, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($school_logo, 40, 8, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

// $pdf->SetFont('roboto', 'B', 11);
// $pdf->SetTextColor(0, 0, 255);
// $pdf->SetAlpha(0.2);
// for ($a = 0; $a <= 8; $a++):
//     $pdf->SetX(0);
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->Ln(10);

//     $pdf->SetX(5);
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->Ln(10);

//     $pdf->SetX(10);
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->MultiCell(90, 5, $settings->set_school_name, 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//     $pdf->Ln(10);
// endfor;


$pdf->AddPage();
$data['student'] = $student;
$data['sy'] = $sy;
$data['term'] = $term;
$data['behaviorRate'] = $behavior;
$data['bh_group'] = $bh_group;
$data['pdf'] = $pdf;
$data['settings'] = $settings;
$this->load->view($short_name . '/reportCardSecondPage', $data);

//Close and output PDF document
ob_end_clean();
$pdf->Output($student->lastname . ', ' . substr($student->firstname, 0, 1) . '_DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+