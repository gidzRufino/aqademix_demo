<?php

function getRating($behaviorRating) {
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
            $star = 'A0';
            break;
        default :
            $star = '';
            break;
    }
    return $star;
}

function getDesc($val){
    if($val >= 90 && $val <= 100):
        return 'O';
    elseif($val >= 85 && $val <= 89.9):
        return 'VS';
    elseif($val >= 80 && $val <= 84.9):
        return 'S';
    elseif($val >= 75 && $val <= 79.9):
        return 'FS';
    elseif($val <= 74.9):
        return 'Failed';
    endif;
}

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

function getMAPEH($pdf, $first, $second, $third, $fourth, $term) {
    if ($second == 0):
        $second = '';
    endif;
    if ($third == 0):
        $third = '';
    endif;
    if ($fourth == 0):
        $fourth = '';
    endif;
    $macFinalAverage = ($first + $second + $third + $fourth) / 4;

    $pdf->SetXY(10, 72);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->MultiCell(40, 5, 'MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    switch ($term):
        case 1:
            $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            break;
        case 2:
            $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, round($second, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            break;
        case 3:
            $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, round($second, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, round($third, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            break;
        case 4:
            $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, round($second, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, round($third, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, round($fourth, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            break;
    endswitch;
    if ($term == 4):
        if ($macFinalAverage >= 75):
            $pdf->MultiCell(24, 5, round($macFinalAverage, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        else:
            $pdf->SetTextColor(255, 0, 0);
            $pdf->MultiCell(24, 5, round($macFinalAverage, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->SetTextColor(000, 0, 0);

        endif;
        if ($macFinalAverage >= 75):
            $pdf->MultiCell(15, 5, 'Passed', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        else:
            $pdf->SetTextColor(255, 0, 0);
            $pdf->MultiCell(15, 5, 'Failed', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->SetTextColor(000, 0, 0);

        endif;
    else:
        $pdf->MultiCell(24, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    endif;
    $pdf->Ln();
    $pdf->SetXY(15, 89);
}

$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('Times', 'B', 8);

//left column

$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$aRec = K_PATH_IMAGES . '/aRec.png';
$pdf->SetFont('Roboto', 'B', 15);
$pdf->Image($aRec, 40, 5, 70, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(25, 6);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(100, 5, 'ACADEMIC PERFORMANCE', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(13);
$pdf->SetX(10);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(57, 10, 'Learning Areas', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 5, 'Periodic Rating', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(33, 5, 'Final Rating', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(57, 10, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 5, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('agency_fb_Bold', 'B', 8);
$pdf->MultiCell(11, 5, 'Num.', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, 'Desc.', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, 'Rem.', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

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
$finalMAPEH = round(($mapeh1 + $mapeh2 + $mapeh3 + $mapeh4) / 4, 2);

$pdf->SetFont('times', 'R', 8);
$pdf->SetFillColor(225, 225, 225);
foreach ($subject_ids as $s) {
    $pdf->SetX(10);
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
//    if ($singleSub->subject_id == 18): //------------ MAPEH gen average ---------------------------//
//        
//        $pdf->MultiCell(57, 5, $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, ($mapeh1 != 0 ? $mapeh1 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, ($mapeh2 != 0 ? $mapeh2 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, ($mapeh3 != 0 ? $mapeh3 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, ($mapeh4 != 0 ? $mapeh4 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
////        $pdf->MultiCell(10, 5, ($finalMAPEH != 0 ? $finalMAPEH : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id == 13):
            $pdf->MultiCell(57, 5, 'MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh1 != 0 ? $mapeh1 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh2 != 0 ? $mapeh2 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh3 != 0 ? $mapeh3 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh4 != 0 ? $mapeh4 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(10, 5, ($finalMAPEH != 0 ? $finalMAPEH : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh4 != 0 ? number_format($finalMAPEH, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh4 != 0 ? getDesc($finalMAPEH) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($mapeh4 != 0 ? ($finalMAPEH < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $pdf->SetX(10);
        endif;
        $pdf->SetFont('times', 'I', 8);
        $pdf->MultiCell(57, 5, '      ' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $finRateNum = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row()->final_rating + $frg->row()->final_rating) / 4, 2);
//        $pdf->MultiCell(10, 5, ($finalMAPEH != 0 ? ($frg->row()->final_rating != '' ? $finalMAPEH : '') : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? number_format($finRateNum, 2) : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? getDesc($finRateNum) : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? ($finRateNum < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    else:
        $subCount++;
        $pdf->MultiCell(57, 5, $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $finRateNum = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row()->final_rating + $frg->row()->final_rating) / 4, 2);
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? number_format($finRateNum, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? getDesc($finRateNum) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($frg->row()->final_rating != 0 ? ($finRateNum < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $firstFinal += $fg->row()->final_rating;
        $secondFinal += $sg->row()->final_rating;
        $thirdFinal += $tg->row()->final_rating;
        $fourthFinal += $frg->row()->final_rating;
        $rateNum += $finRateNum;
    endif;
    $pdf->Ln();
}

$generalFinal = round($generalFinal / $i, 2);
if ($generalFinal <= 75 && $generalFinal >= $settings->final_passing_mark):
    $generalFinal = 75;
endif;

$aveFirst = round((($firstFinal + $mapeh1) / ($subCount + 1)), 2);
$aveSecond = round((($secondFinal + $mapeh2) / ($subCount + 1)), 2);
$aveThird = round((($thirdFinal + $mapeh3) / ($subCount + 1)), 2);
$aveFourth = round((($fourthFinal + $mapeh4) / ($subCount + 1)), 2);
$aveFinRate = round(($rateNum + $finalMAPEH) / ($subCount + 1), 2);

$pdf->SetX(10);
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(57, 5, 'Average', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, ($aveFirst != 0 ? number_format($aveFirst, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, ($aveSecond != 0 ? number_format($aveSecond, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, ($aveThird != 0 ? number_format($aveThird, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, ($aveFourth != 0 ? number_format($aveFourth, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, ($aveFourth != 0 ? number_format($aveFinRate, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, ($aveFourth != 0 ? getDesc($aveFinRate) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, ($aveFourth != 0 ? ($aveFinRate < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//if ($term != 4):
//    $pdf->MultiCell(20, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//else:
//    $pdf->MultiCell(20, 5, transmuteGrade($generalFinal), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//endif;
//$pdf->MultiCell(19, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//        $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M

if (!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
    Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinal, $sy);
endif;

$gLegend = K_PATH_IMAGES . '/gLegend.png';
$pdf->Image($gLegend, 25, 110, 100, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln(15);

$pdf->SetX(10);
$pdf->SetFont('times', 'B', 12);
$pdf->MultiCell(127, 10, 'ADHERENCE TO CORE VALUES', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(7);

$pdf->SetX(7);
$pdf->SetFont('roboto', 'B', 12);
$pdf->SetFillColor(242, 219, 219);
$pdf->MultiCell(93, 6, 'Indicators', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '1', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '2', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '3', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '4', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetX(7);
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(219, 229, 241);
$bhRate = Modules::run('reports/getBhGroup', 2, NULL, 12);
$pdf->MultiCell(93, 6, 'Maka - Diyos', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('agency_fb', 'B', 10);
$c = 1;
foreach ($bhRate as $bh):
    if ($bh->bh_group == 1):
        $bhRate1 = Modules::run('gradingsystem/getBHRating', $student->uid, 1, $sy, $bh->bh_id);
        $bhRate2 = Modules::run('gradingsystem/getBHRating', $student->uid, 2, $sy, $bh->bh_id);
        $bhRate3 = Modules::run('gradingsystem/getBHRating', $student->uid, 3, $sy, $bh->bh_id);
        $bhRate4 = Modules::run('gradingsystem/getBHRating', $student->uid, 4, $sy, $bh->bh_id);
        $pdf->SetX(7);
        if ($bh->bh_id == 5):
            $pdf->SetFillColor(225, 225, 225);
            $pdf->MultiCell(93, 5, '', 1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $pdf->SetX(7);
            $c = 1;
        endif;
        $pdf->MultiCell(93, 5, $c++ . '. ' . $bh->bh_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate1), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate3), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate4), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endif;
endforeach;


///========================= right side page ============================================///

$pdf->SetXY(157, 5);
$pdf->SetFont('roboto', 'B', 12);
$pdf->SetFillColor(242, 219, 219);
$pdf->MultiCell(93, 6, 'Indicators', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '1', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '2', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '3', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '4', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetX(157);
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(219, 229, 241);
$pdf->MultiCell(93, 6, 'Makatao', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('agency_fb', 'B', 10);
$c = 1;
foreach ($bhRate as $bh):
    if ($bh->bh_group == 2):
        $bhRate1 = Modules::run('gradingsystem/getBHRating', $student->uid, 1, $sy, $bh->bh_id);
        $bhRate2 = Modules::run('gradingsystem/getBHRating', $student->uid, 2, $sy, $bh->bh_id);
        $bhRate3 = Modules::run('gradingsystem/getBHRating', $student->uid, 3, $sy, $bh->bh_id);
        $bhRate4 = Modules::run('gradingsystem/getBHRating', $student->uid, 4, $sy, $bh->bh_id);
        $pdf->SetX(157);
        if ($bh->bh_id == 19):
            $pdf->SetFillColor(225, 225, 225);
            $pdf->MultiCell(93, 4, '', 1, 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->Ln();
            $pdf->SetX(157);
            $c = 1;
        endif;
        $pdf->MultiCell(93, 5, $c++ . '. ' . $bh->bh_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate1), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate3), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate4), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endif;
endforeach;

$pdf->SetX(157);
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(219, 229, 241);
$pdf->MultiCell(93, 6, 'Makakalikasan', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('agency_fb', 'B', 10);
$c = 1;
foreach ($bhRate as $bh):
    if ($bh->bh_group == 3):
        $bhRate1 = Modules::run('gradingsystem/getBHRating', $student->uid, 1, $sy, $bh->bh_id);
        $bhRate2 = Modules::run('gradingsystem/getBHRating', $student->uid, 2, $sy, $bh->bh_id);
        $bhRate3 = Modules::run('gradingsystem/getBHRating', $student->uid, 3, $sy, $bh->bh_id);
        $bhRate4 = Modules::run('gradingsystem/getBHRating', $student->uid, 4, $sy, $bh->bh_id);
        $pdf->SetX(157);
        if ($bh->bh_id == 19):
            $pdf->SetFillColor(225, 225, 225);
            $pdf->MultiCell(93, 4, '', 1, 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->Ln();
            $pdf->SetX(157);
            $c = 1;
        endif;
        $pdf->MultiCell(93, 5, $c++ . '. ' . $bh->bh_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate1), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate3), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate4), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endif;
endforeach;

$pdf->SetX(157);
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(219, 229, 241);
$pdf->MultiCell(93, 6, 'Makabansa', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('agency_fb', 'B', 10);
$c = 1;
foreach ($bhRate as $bh):
    if ($bh->bh_group == 4):
        $bhRate1 = Modules::run('gradingsystem/getBHRating', $student->uid, 1, $sy, $bh->bh_id);
        $bhRate2 = Modules::run('gradingsystem/getBHRating', $student->uid, 2, $sy, $bh->bh_id);
        $bhRate3 = Modules::run('gradingsystem/getBHRating', $student->uid, 3, $sy, $bh->bh_id);
        $bhRate4 = Modules::run('gradingsystem/getBHRating', $student->uid, 4, $sy, $bh->bh_id);
        $pdf->SetX(157);
        if ($bh->bh_id == 38):
            $pdf->SetFillColor(225, 225, 225);
            $pdf->MultiCell(93, 4, '', 1, 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->Ln();
            $pdf->SetX(157);
            $c = 1;
        endif;
        $pdf->MultiCell(93, 5, $c++ . '. ' . $bh->bh_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate1), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate3), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, getRating($bhRate4), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endif;
endforeach;

$bLegend = K_PATH_IMAGES . '/bLegend.png';
$pdf->Image($bLegend, 185, 185, 80, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln();
$pdf->SetXY(157, 187);
$pdf->SetFont('roboto', 'B', 10);
$pdf->MultiCell(133, 5, 'LEGEND', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(157);
$pdf->SetFont('times', 'R', 8);
$pdf->MultiCell(35, 5, '1.', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(8, 5, 'AO -', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'R', 8);
$pdf->MultiCell(23, 5, 'Always Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '3.', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(8, 5, 'RO -', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'R', 8);
$pdf->MultiCell(23, 5, 'Rarely Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(157);
$pdf->SetFont('times', 'R', 8);
$pdf->MultiCell(35, 5, '2.', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(8, 5, 'SO -', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'R', 8);
$pdf->MultiCell(27, 5, 'Sometimes Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetX(223);
$pdf->MultiCell(10, 5, '4.', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(8, 5, 'NO -', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'R', 8);
$pdf->MultiCell(23, 5, 'Not Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
