<?php

//function transmuteGrade($grade) {
//    if ($grade != ''):
//        $plg = Modules::run('gradingsystem/new_gs/getTransmutation', $grade);
//    else:
//        $plg = '';
//    endif;
//    return $plg;
//}

function getGrade($subject) {
    $plg = Modules::run('gradingsystem/getLetterGrade', $subject->row()->final_rating);
    foreach ($plg->result() as $plg) {
        if ($subject->row()->final_rating >= $plg->from_grade && $subject->row()->final_rating <= $plg->to_grade) {


            $grade = $plg->letter_grade;

            if ($grade != ""):
                $grade = $grade;
            else:
                $grade = "";
            endif;
        }
    }

    return $grade;
}

$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('Times', 'B', 8);

//$pdf->SetAlpha(0.3);
//$pdf->Image(base_url() . 'images/forms/summerhill.png', 20, 30, 110, 120);
//$pdf->SetAlpha(1);
//
//
//$pdf->SetAlpha(0.3);
//$pdf->Image(base_url() . 'images/forms/summerhill.png', 170, 30, 110, 120);
//$pdf->SetAlpha(1);
//left column

$pdf->SetFont('Roboto', 'B', 12);
$pdf->SetXY(25, 8);
$pdf->SetDrawColor(205, 92, 92);
$pdf->SetLineWidth(0.7, 3);
$pdf->SetTextColor(194, 8, 8);
$pdf->MultiCell(100, 10, 'ACADEMIC PERFORMANCE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);
$pdf->SetX(10);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->SetLineWidth(0, 3);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetTextColor(28, 134, 238);
$pdf->MultiCell(40, 10.5, 'Learning Areas', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(48, 5, 'Periodic Rating', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(39, 5, 'Final Rating', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->SetFont('Helvetica', 'N', 8);
$pdf->Ln();
$pdf->SetXY(50, 28);
$pdf->MultiCell(12, 5, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Final', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(19, 5, 'Action', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetTextColor(0, 0, 0);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
//$subject = explode(',', $subject_ids->subject_id);
$i = 0;
$m = 0;
$mp = 0;
$mapeh1 = 0;
$mapeh2 = 0;
$mapeh3 = 0;
$mapeh4 = 0;
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
$finalMAPEH = round(($mapeh1 + $mapeh2 + $mapeh3 + $mapeh4) / 4);
$subCount = 0;

foreach ($subject_ids as $s):
    $pdf->SetX(10);
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);

    if ($singleSub->subject_id != 18):
        if ($singleSub->parent_subject == 11):
            if ($singleSub->subject_id == 13):
                $pdf->MultiCell(40, 5, 'MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(12, 5, ($mapeh1 == 0 ? '' : $mapeh1), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(12, 5, ($mapeh2 == 0 ? '' : $mapeh2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(12, 5, ($mapeh3 == 0 ? '' : $mapeh3), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(12, 5, ($mapeh4 == 0 ? '' : $mapeh4), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('Helvetica', 'N', 8);
                $pdf->MultiCell(20, 5, ($term != 4 ? '' : $finalMAPEH), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(19, 5, ($term != 4 ? '' : ($finalMAPEH >= 75 ? 'Passed' : 'Failed')), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln();
                $pdf->SetX(10);
            endif;
            $pdf->MultiCell(40, 5, '        ' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $finRateNum = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row()->final_rating + $frg->row()->final_rating) / 4);
            $pdf->SetFont('Helvetica', 'N', 8);
            $pdf->MultiCell(20, 5, ($term == 4 ? $finRateNum : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(19, 5, ($term == 4 ? ($finRateNum < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        else:
            $subCount++;
            $pdf->MultiCell(40, 5, $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $finRateNum = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row()->final_rating + $frg->row()->final_rating) / 4);
            $pdf->SetFont('Helvetica', 'N', 8);
            $pdf->MultiCell(20, 5, ($term == 4 ? $finRateNum : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(19, 5, ($term == 4 ? ($finRateNum < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $firstFinal += $fg->row()->final_rating;
            $secondFinal += $sg->row()->final_rating;
            $thirdFinal += $tg->row()->final_rating;
            $fourthFinal += $frg->row()->final_rating;
            $rateNum += $finRateNum;
        endif;
        $pdf->Ln();
    endif;
endforeach;

$generalFinal = round($generalFinal / $i, 2);
if ($generalFinal <= 75 && $generalFinal >= $settings->final_passing_mark):
    $generalFinal = 75;
endif;

$aveFirst = round((($firstFinal + $mapeh1) / ($subCount + 1)));
$aveSecond = round((($secondFinal + $mapeh2) / ($subCount + 1)));
$aveThird = round((($thirdFinal + $mapeh3) / ($subCount + 1)));
$aveFourth = round((($fourthFinal + $mapeh4) / ($subCount + 1)));
$aveFinRate = round(($rateNum + $finalMAPEH) / ($subCount + 1));

$pdf->SetX(10);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(40, 5, 'Average', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, ($aveFirst != 0 ? $aveFirst : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, ($aveSecond != 0 ? $aveSecond : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, ($aveThird != 0 ? $aveThird : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, ($aveFourth != 0 ? $aveFourth : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, ($term != 4 ? '' : $aveFinRate), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(19, 5, ($term != 4 ? '' : ($aveFinRate < 75 ? 'Failed' : 'Passed')), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M

if (!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
    Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinal, $sy);
endif;
$pdf->Ln();

$pdf->SetX(25);
$pdf->SetFont('Roboto', 'B', 12);
$pdf->MultiCell(100, 10, 'GUIDELINES FOR RATING', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(25);
$pdf->SetFont('Helvetica', 'R', 9);
$pdf->MultiCell(50, 10, 'OUTSTANDING (0) / 90% and above', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 10, 'VERY SATISFACTORY (VS) / 85-89%', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(25);
$pdf->MultiCell(50, 10, '  SATISFACTORY (S) / 80-84%   ', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 10, 'FAIRLY SATISFACTORY (FS) / 75-79%', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(25);
$pdf->MultiCell(100, 5, 'DID NOT MEET EXPECTATIONS (DNME) / 74% and below', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(25);
$pdf->SetFont('Roboto', 'B', 12);
$pdf->MultiCell(100, 10, 'ATTENDANCE RECORD', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->MultiCell(15, 10, 'Months', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    endif;
    $pdf->MultiCell(10, 10, date("M", mktime(0, 0, 0, $m, 1, 2000)), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}
$pdf->MultiCell(10, 10, 'Total', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetFont('Helvetica', 'R', 9);
$pdf->SetX(10);
$pdf->MultiCell(15, 10, 'Days of School', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $n = $m;
        $schoolYear = $sy + 1;
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    else:
        $schoolYear = $sy;
    endif;

    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays - $holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    $pdf->MultiCell(10, 10, $totalDaysInAMonth, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}

$pdf->MultiCell(10, 10, $totalDays, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $student->st_id, $student->grade_id, $sy);
$pdf->SetX(10);
$pdf->MultiCell(15, 10, 'Days of Present', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $n = $m;
        $schoolYear = $sy + 1;
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    else:
        $schoolYear = $sy;
    endif;

    $monthName = date('F', mktime(0, 0, 0, $m, 10));

    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays - $holiday->num_rows();
    if ($this->session->userdata('attend_auto')):
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
    else:
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
    endif;
    if ($pdays > $totalDaysInAMonth):
        $pdays = $totalDaysInAMonth;
    endif;

    $pdf->MultiCell(10, 10, $attendance->$monthName, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    $total_pdays += $attendance->$monthName;
    $pdays = 0;
}


$pdf->MultiCell(10, 10, $total_pdays, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(15, 10, 'Days of Absence', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$tardy = 0;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $n = $m;
        $schoolYear = $sy + 1;
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    else:
        $schoolYear = $sy;
    endif;

    $monthName = date('F', mktime(0, 0, 0, $m, 10));

    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays - $holiday->num_rows();
    if ($this->session->userdata('attend_auto')):
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
    else:
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
    endif;

    if ($pdays > $totalDaysInAMonth):
        $pdays = $totalDaysInAMonth;
    else:
        $pdays = $attendance->$monthName;
    endif;

    $pdf->MultiCell(10, 10, ($totalDaysInAMonth - $pdays), 'BR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    $total_adays += ($totalDaysInAMonth - $pdays);
    $pdays = 0;
}
$pdf->MultiCell(10, 10, $total_adays, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(40);

$bh_group = Modules::run('reports/getBhGroup', 1, 0);
//Start of right Column
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(28, 134, 238);
$pdf->SetFont('Roboto', 'B', 15);
$pdf->SetXY(145, 8);
$pdf->MultiCell(0, 10, 'CHARACTER BUILDING', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->SetX(155);
$pdf->MultiCell(70, 5, 'TRAITS', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '1', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '2', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '3', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '4', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('Helvetica', 'N', 9);
$t = 1;

foreach ($bh_group as $bhg):
    $pdf->SetX(155);
    $pdf->MultiCell(70, 4, $t++ . '. ' . $bhg->bh_name, 1, 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(15, 4, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 1, $sy, $bhg->bh_id)), 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(15, 4, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 2, $sy, $bhg->bh_id)), 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(15, 4, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 3, $sy, $bhg->bh_id)), 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(15, 4, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 4, $sy, $bhg->bh_id)), 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->Ln();
endforeach;

$pdf->SetFont('Roboto', 'B', 10);
$pdf->SetXY(170, 110);
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 3, 'color' => array(255, 0, 0)));
$pdf->SetFillColor(255, 255, 128);
$pdf->SetDrawColor(190, 92, 92);
$pdf->SetLineWidth(0.3, 7);
$pdf->MultiCell(100, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');

$pdf->SetXY(170, 110);
$pdf->MultiCell(100, 5, 'GUIDELINES FOR RATING', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(172);
$pdf->SetFont('Helvetica', 'R', 8);
$pdf->SetTextColor(194, 8, 8);
$pdf->MultiCell(5, 5, 'A', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(21, 5, '- Very Good', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(194, 8, 8);
$pdf->MultiCell(5, 5, 'B', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(21, 5, '- Good', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(194, 8, 8);
$pdf->MultiCell(5, 5, 'C', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(21, 5, '- Fair', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(194, 8, 8);
$pdf->MultiCell(5, 5, 'D', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(21, 5, '- Poor', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 5, 'color' => array(255, 0, 0)));
$pdf->SetFont('Roboto', 'B', 10);
$pdf->SetXY(185, 125);
$pdf->setFillColor(255, 193, 193);
$pdf->MultiCell(75, 5, 'NARRATIVE REPORT', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->SetX(155);
$pdf->MultiCell(35, 5, 'First Quarter', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(155);
$pdf->MultiCell(35, 5, 'Second Quarter', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(155);
$pdf->MultiCell(35, 5, 'Third Quarter', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(155);
$pdf->MultiCell(35, 5, 'Fourth Quarter', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(155);
$pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

function getRating($behaviorRating) {
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

        default :
            $star = '';
            break;
    }
    return $star;
}
