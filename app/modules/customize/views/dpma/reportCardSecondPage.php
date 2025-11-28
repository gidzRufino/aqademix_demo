<?php

function getGrade($subject)
{
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

function getMAPEH($pdf, $first, $second, $third, $fourth, $term)
{
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
$pdf->SetFont('times', 'B', 12);
$pdf->SetY(5);
$pdf->MultiCell(0, 6, 'REPORT ON LEARNING PROGRESS AND ACHIEVEMENT', 0, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(90, 10, 'Learning Areas', 'RTL', 'C', 1, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(48, 10, 'QUARTER', 'LTR', 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, 'Final', 'RTL', 'C', 1, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(20, 10, 'Remarks', 'RTL', 'C', 1, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(90, 0, '', 'LBR', 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(12, 0, '1', 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(12, 0, '2', 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(12, 0, '3', 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(12, 0, '4', 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Rating', 'RBL', 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 'RBL', 'C', 1, 0, '', '', true, 0, false, true, 0, 'T');
$pdf->Ln();

$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
$subject = explode(',', $subject_ids->subject_id);
$i = 0;
$m = 0;
$mp = 0;
$mapeh1 = 0;
$mapeh2 = 0;
$mapeh3 = 0;
$mapeh4 = 0;
$finalMAPEH = 0;
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
$q = 1;

$pdf->SetFont('times', 'R', 10);
$pdf->SetFillColor(225, 225, 225);
foreach ($subject_ids as $s) {
    $pdf->SetX(15);
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
    if ($singleSub->parent_subject == 11):
        if ($q == 1):
            $pdf->MultiCell(90, 5, 'MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh1 != 0 ? $mapeh1 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh2 != 0 ? $mapeh2 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh3 != 0 ? $mapeh3 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh4 != 0 ? $mapeh4 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, ($mapeh4 != 0 ? round($finalMAPEH) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, ($mapeh4 != 0 ? (round($finalMAPEH) < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $pdf->SetX(15);
        endif;
        $pdf->SetFont('times', 'I', 10);
        $pdf->MultiCell(90, 5, '      ' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $finRateNum = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row()->final_rating + $frg->row()->final_rating) / 4, 2);
        $pdf->MultiCell(20, 5, ($frg->row()->final_rating != 0 ? round($finRateNum) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, ($frg->row()->final_rating != 0 ? (round($finRateNum) < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $q++;
    else:
        $subCount++;
        $pdf->MultiCell(90, 5, $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $finRateNum = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row()->final_rating + $frg->row()->final_rating) / 4, 2);
        $pdf->MultiCell(20, 5, ($frg->row()->final_rating != 0 ? round($finRateNum) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, ($frg->row()->final_rating != 0 ? (round($finRateNum) < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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

$pdf->SetFillColor(30, 0, 0, 0);
$pdf->SetX(15);
$pdf->SetFont('times', 'B', 10);
$pdf->MultiCell(138, 5, 'General Average    ', 1, 'R', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, $finalMAPEH, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, ($aveFourth != 0 ? (round($aveFinRate) < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(9);

$pdf->SetX(15);
$pdf->MultiCell(178, 5, 'GRADING GUIDELINES', 0, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(89, 5, '90 - 100', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(89, 5, 'Passed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetX(15);
$pdf->MultiCell(89, 5, '85 - 89', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(89, 5, 'Passed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetX(15);
$pdf->MultiCell(89, 5, '80 - 84', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(89, 5, 'Passed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetX(15);
$pdf->MultiCell(89, 5, '75 - 79', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(89, 5, 'Passed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetX(15);
$pdf->MultiCell(89, 5, 'Below 75', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(89, 5, 'Failed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$core = Modules::run('reports/getCoreValues');
$pdf->SetFont('times', 'B', 12);
$pdf->MultiCell(0, 6, 'REPORT ON LEARNER\'S OBSERVED VALUES', 0, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('times', 'B', 10);
$pdf->SetX(15);
$pdf->MultiCell(45, 3, 'Core Values', 'RTL', 'C', 1, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(85, 3, 'Behavior Statements', 'TL', 'C', 1, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(48, 3, 'Quarter', 'TLR', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(45, 0, '', 'RBL', 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 0, '', 'BL', 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(12, 4, '1', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 4, '2', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 4, '3', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 4, '4', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('times', 'R', 10);
foreach ($core as $c):
    $traits = Modules::run('reports/getSubBH', $c->core_id);
    $pdf->SetX(15);
    $ht = ($c->core_id == 4 ? 22 : 11);
    $pdf->MultiCell(45, $ht, '      ' . $c->core_values, 1, 'L', 0, 0, '', '', true, 0, false, true, $ht, 'M');
    foreach ($traits as $t):
        $pdf->MultiCell(85, 11, $t->bh_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(12, 11, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 1, $sy, $t->bh_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(12, 11, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 2, $sy, $t->bh_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(12, 11, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 3, $sy, $t->bh_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(12, 11, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id, 4, $sy, $t->bh_id)), 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->Ln();
        $pdf->SetX(60);
    endforeach;
endforeach;
$pdf->Ln(5);

$pdf->SetFont('times', 'B', 10);
$pdf->SetX(15);
$pdf->MultiCell(45, 5, 'Marking', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(85, 5, 'Non-Numerical Rating', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(45, 5, 'AO', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 5, 'Always Observed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(45, 5, 'SO', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 5, 'Sometimes Observed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(45, 5, 'RO', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 5, 'Rarely Observed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(45, 5, 'NO', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 5, 'Not Observed', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(-15);

$pdf->SetX(155);
$pdf->SetFont('times', 'I', 8);
$pdf->MultiCell(30, 10, 'NOT VALID WITHOUT SCHOOL DRY SEAL', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(25);

$pdf->SetFont('helvetica', 'R', 11);
$pdf->MultiCell(0, 6, '"One test of the correctness of education procedure is the happiness of the child."', 0, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln(5);

$pdf->SetX(120);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->MultiCell(65, 6, '- DR. MARIA A MONTESSORI', 0, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();
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
