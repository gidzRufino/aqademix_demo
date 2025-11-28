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
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);

function getDesc($val){
    if($val >= 91 && $val <= 100):
        return 'A';
    elseif($val >= 86 && $val <= 90):
        return 'P';
    elseif($val >= 81 && $val <= 85):
        return 'AP';
    elseif($val >= 75 && $val <= 80):
        return 'D';
    elseif($val <= 74):
        return 'B';
    endif;
}
function getRating($behaviorRating)
{
    $rate = $behaviorRating->row()->rate;
    switch ($rate) {
        case 1:
            $star = 'D';
            break;
        case 2:
            $star = 'C';
            break;
        case 3:
            $star = 'B';
            break;
        case 4:
            $star = 'A';
            break;

        default:
            $star = '';
            break;
    }
    return $star;
}

//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('mdY',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->temp_bdate;
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[1];
    $d = $bdateItems[2];
    $y = $bdateItems[0];
    $thisYearBdate = $m.$d.$settings->school_year;
    $now = $settings->school_year;
    $age = abs($now - $y);
    
    if(abs($thisYearBdate>$firstFridayOfJune)){
        $yearsOfAge = $age - 1;
    }else{
        $yearsOfAge = $age;
    }

//--------- For Attendance ------------------------------------ //

$gs_start = date('m', strtotime($settings->bosy));
$gs_end = date('m', strtotime($settings->eosy));
$gsDays = Modules::run('reports/getRawSchoolDays', $sy, 2);


//start of the left column

$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetXY(5,15);
$pdf->MultiCell(148, 10, 'PERIODIC TABLE',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('Helvetica', 'R', 10);
$pdf->MultiCell(50, 5, 'Learning Areas', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, '1st', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, '2ND', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, '3RD', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, '4TH', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Ln();

foreach ($subject_ids as $sp):
    $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
    if ($singleSub->parent_subject == 11):
        $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 1, $sy);
        $fg1 += $fg->row()->final_rating;
        $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 2, $sy);
        $sg1 += $sg->row()->final_rating;
        $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 3, $sy);
        $tg1 += $tg->row()->final_rating;
        $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 4, $sy);
        $frg1 += $frg->row()->final_rating;
        $mp += 1;
    endif;
endforeach;

$mapeh1 = round(($fg1 / $mp));
$mapeh2 = round(($sg1 / $mp));
$mapeh3 = round(($tg1 / $mp));
$mapeh4 = round(($frg1 / $mp));
$finalMAPEH = round(($mapeh1 + $mapeh2 + $mapeh3 + $mapeh4) / 4, 2);

$pdf->SetFont('Helvetica', 'R', 8);
$pdf->SetFillColor(225, 225, 225);
foreach ($subject_ids as $s) {
    $pdf->SetX(5);
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id == 13):
            $pdf->MultiCell(50, 5, 'MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh1 != 0 ? getDesc($mapeh1) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh1 != 0 ? $mapeh1 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh2 != 0 ? getDesc($mapeh2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh2 != 0 ? $mapeh2 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh3 != 0 ? getDesc($mapeh3) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh3 != 0 ? $mapeh3 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh4 != 0 ? getDesc($mapeh4) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh4 != 0 ? $mapeh4 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endif;
        $pdf->SetX(5);
        $pdf->SetFont('Helvetica', 'I', 8);
        $pdf->MultiCell(50, 5, '      ' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($fg->row()->final_rating != 0 ? getDesc($fg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($sg->row()->final_rating != 0 ? getDesc($sg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($tg->row()->final_rating != 0 ? getDesc($tg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? getDesc($frg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    else:
        $subCount++;
        $pdf->SetFont('Helvetica', 'R', 8);
        $pdf->MultiCell(50, 5, $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($fg->row()->final_rating != 0 ? getDesc($fg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($sg->row()->final_rating != 0 ? getDesc($sg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($tg->row()->final_rating != 0 ? getDesc($tg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? getDesc($frg->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $firstFinal += $fg->row()->final_rating;
        $secondFinal += $sg->row()->final_rating;
        $thirdFinal += $tg->row()->final_rating;
        $fourthFinal += $frg->row()->final_rating;
        $rateNum += $finRateNum;
    endif;
    $pdf->Ln();
}

$aveFirst = round((($firstFinal + $mapeh1) / ($subCount + 1)), 2);
$aveSecond = round((($secondFinal + $mapeh2) / ($subCount + 1)), 2);
$aveThird = round((($thirdFinal + $mapeh3) / ($subCount + 1)), 2);
$aveFourth = round((($fourthFinal + $mapeh4) / ($subCount + 1)), 2);
$genAve = round(($aveFirst + $aveSecond + $aveThird + $aveFourth) / 4, 2);

$pdf->SetX(5);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(50, 5, 'Average', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, ($aveFirst != 0 ? number_format($aveFirst, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, ($aveSecond != 0 ? number_format($aveSecond, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, ($aveThird != 0 ? number_format($aveThird, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, ($aveFourth != 0 ? number_format($aveFourth, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7);

$pdf->SetX(5);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->MultiCell(37, 5, 'GENERAL AVERAGE:', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, $genAve, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'REMARKS:', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);

$pdf->SetX(5);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(33, 5, 'LEGEND:', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('Helvetica', 'R', 8);
$pdf->SetX(23);
$pdf->MultiCell(50, 5, 'Beginning', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'B', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '74% and Below', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(23);
$pdf->MultiCell(50, 5, 'Developing', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'D', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '75% - 80%', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(23);
$pdf->MultiCell(50, 5, 'Approaching Proficiency', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'AP', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '81% - 85%', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(23);
$pdf->MultiCell(50, 5, 'Proficient', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'P', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '86% - 90%', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(23);
$pdf->MultiCell(50, 5, 'Advance', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'A', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '91% and Above', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);

$pdf->SetX(5);
$pdf->MultiCell(25, 7, 'Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $monthName = date('M', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $pdf->MultiCell(10, 7, $monthName, 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
endfor;
$pdf->MultiCell(12, 7, 'Total', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('Helvetica', 'R', 8);
$pdf->MultiCell(25, 7, 'Days of School', 1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $pdf->MultiCell(10, 7, $gsDays->$monthName, 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $totalDays += $gsDays->$monthName;
endfor;

$pdf->MultiCell(12, 7, $totalDays, 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $student->st_id, $student->grade_id, $sy);
$sprDetails = Modules::run('sf10/getSPRrec', $student->st_id, $sy, NULL, $student->grade_id);
$pdays = Modules::run('sf10/getAttendanceOveride', $sprDetails->spr_id, $sprDetails->school_year, $student->st_id);

$pdf->SetX(5);
$pdf->MultiCell(25, 7, 'Days Present', 1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $sy);
    $holiday = Modules::run('calendar/holidayExist', $m, $sy);
    $totalDaysInAMonth = $totalDays - $holiday->num_rows();
    $pdf->MultiCell(10, 7, ($pdays ? $pdays->row()->$monthName : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $total_pdays += ($pdays ? $pdays->row()->$monthName : 0);
endfor;

$pdf->MultiCell(12, 7, $total_pdays, 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(5);
$pdf->MultiCell(25, 7, 'Times Tardy', 1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
    $m = $i;
    $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
    $pdf->MultiCell(10, 7, ($attTardy->$monthName != 0 ? $attTardy->$monthName : ''), 'BR', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $tardy += $attTardy->$monthName;
endfor;
$pdf->MultiCell(12, 7, ($tardy != 0 ? $tardy : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->SetXY(155, 10);
$pdf->SetFont('helvetica', 'B', 12);
// Title Right Side Column
$pdf->MultiCell(0, 10, strtoupper($settings->set_school_name),0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetX(159);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(75, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'LRN:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, ($student->lrn == '' ? $student->st_id : $student->lrn),'B' , 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);

$pdf->SetX(159);
$pdf->MultiCell(13, 5, 'Name: ',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110 , 5, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(159);
$pdf->MultiCell(13, 5, 'Level:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110 , 5, $student->level,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$next = $sy + 1;

// $behaviorRate = Modules::run('reports/getBhGroup', 2, 1, NULL);
$behaviorRate = Modules::run('gradingsystem/getCoreValues');

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Ln(10);
$pdf->SetX(159);
$pdf->MultiCell(0, 10, 'CHARACTER BUILDING ACTIVITIES',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetX(155);
$pdf->MultiCell(60, 10, 'TRAITS', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(72, 5, 'RATING PERIOD', 'TRB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'R', 8);
$pdf->SetX(155);
$pdf->MultiCell(60, 5, '', 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, '1st', 'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, '2nd', 'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, '3rd', 'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, '4th', 'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

foreach ($behaviorRate as $bhr):
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->setX(155);
    $pdf->MultiCell(60, 5, $bhr->core_values, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid, 1, $sy, $bhr->core_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid, 2, $sy, $bhr->core_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid, 3, $sy, $bhr->core_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid, 4, $sy, $bhr->core_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
endforeach;

$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetX(159);
$pdf->MultiCell(0, 10, 'GUIDELINES FOR RATING',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'R', 8);
$pdf->SetX(170);
$pdf->MultiCell(25, 5, 'A', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, 'VERY GOOD', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(170);
$pdf->MultiCell(25, 5, 'B', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, 'GOOD', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(170);
$pdf->MultiCell(25, 5, 'C', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, 'FAIR', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(170);
$pdf->MultiCell(25, 5, 'D', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, 'POOR', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(159);
$pdf->MultiCell(0, 10, 'ACCOMPLISHED BY :',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetX(159);
$pdf->MultiCell(55, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $adv, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(159);
$pdf->MultiCell(55, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'CLASS ADVISER',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetFont('helvetica', 'I', 6);
$pdf->Ln(8);
$pdf->SetX(165);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

// $pdf->Image($image_file, 165, 15, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
// $pdf->Image($division_logo, 265 , 15, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

//Close and output PDF document
ob_end_clean();
$pdf->Output($student->lastname.', '.substr($student->firstname, 0, 1).'_DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+