<?php

$subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);

$coreSubsFSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 1, $student->strnd_id, 1);
$appliedSubsFSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 1, $student->strnd_id);

$coreSubsSSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 2, $student->strnd_id, 1);
$appliedSubsSSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 2, $student->strnd_id);

$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('helvetica', 'B', 8);


//left column

$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetxY(10, 8);
$pdf->MultiCell(148, 10, 'PERIODIC RATING', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->Ln();
// THIS IS THE LEFT SIDE
$pdf->SetX(10);
$pdf->Ln(8);

$finalGrade = 0;

$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetX(10);
$pdf->MultiCell(35, 13, "LEARNING AREAS", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(28, 8, "Quarterly Rating", '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(12, 8, "FINAL", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(19, 13, "REMARKS", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(10, 8, "", '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln();

$pdf->SetXY(10, 35);
$pdf->MultiCell(35, 5, '', 'BL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, "RATING", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$numSubjects = 0;
foreach ($subject as $s) {
    $pdf->SetX(10);
    $numSubjects++;
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $finalFirst = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $finalSecond = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $finalThird = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $finalFourth = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
    $finalQGrade = ($finalFourth->row() ? ($finalFirst->row()->final_rating + $finalSecond->row()->final_rating + $finalThird->row()->final_rating + $finalFourth->row()->final_rating) : 0);
    $finalGrade += round($finalQGrade  / 4, 2);
    
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->MultiCell(35, 8, '   ' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($finalFirst->row() ? $finalFirst->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($finalSecond->row() ? $finalSecond->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($finalThird->row() ? $finalThird->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($finalFourth->row() ? $finalFourth->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(12, 8, ($finalFourth->row() ? round($finalQGrade  / 4, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'T');
    $pdf->MultiCell(19, 8, (round($finalQGrade  / 4, 2) >= 75?"PASSED":"FAILED"), '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->Ln();
 
    
}

$pdf->SetX(10);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(94, 5, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(35, 8, 'General Average', 1, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(7, 8, '', 'BT', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(7, 8, '', 'BT', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(7, 8, '', 'BT', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(7, 8, '', 'BT', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, ($finalGrade != 0 ? round($finalGrade/$numSubjects,2,PHP_ROUND_HALF_DOWN) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(18, 8, (round($finalGrade/$numSubjects,2,PHP_ROUND_HALF_DOWN) >= 75?"PASSED":"FAILED"), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$generalFinal = round($finalGrade/$numSubjects,2,PHP_ROUND_HALF_DOWN);
   
        if (!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
            if ($generalFinal != ""):
                Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinal, $sy);
            endif;
        endif;

$pdf->SetXY(107, 27);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(35, 5, 'LEGEND:', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetXY(107, 32.5);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, 'Outstanding', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 40);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, '90 and above', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 50);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, 'Very Satisfactory', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 58);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, '85 - 89', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 68);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, 'Satisfactory', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 76);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, '80 - 84', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 86);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, 'Fairly Satisfactory', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 94);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, '75 - 79', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 104);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, 'Did not Meet Expectation', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(107, 112);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(35, 10, '74 - below', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

//------------------------------------- Start of right Column -------------------------------------------------------------------------------------------

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetXY(145, 8);
$pdf->MultiCell(0, 10, 'CHARACTER BUILDING ACTIVITIES', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(19);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetX(155);
$pdf->MultiCell(45, 13, "CHARACTER TRAITS", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(48, 8, "GRADING PERIOD", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$pdf->SetXY(155, 34);
$pdf->MultiCell(45, 5, '', 'BLR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "TOTAL", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'N', 8);

function getRating($rate) {
    switch ($rate) {
        case 1:
            $star = 'E';
            break;
        case 2:
            $star = 'D';
            break;
        case 3:
            $star = 'C';
            break;
        case 4:
            $star = 'B';
            break;
        case 5:
            $star = 'A';
            break;
        default :
            $star = '';
            break;
    }
    return $star;
}

$customList = Modules::run('gradingsystem/getElemBHRate', 12);

$t = 1;
$averagePerQuarter = 0;
foreach($customList as $cl):
    $firstbhg   =   Modules::run('gradingsystem/getBHRating', $student->st_id, 1, $sy, $cl->bh_id);
    $secondbhg  =   Modules::run('gradingsystem/getBHRating', $student->st_id, 2, $sy, $cl->bh_id);
    $thirdbhg   =   Modules::run('gradingsystem/getBHRating', $student->st_id, 3, $sy, $cl->bh_id);
    $fourthbhg  =   Modules::run('gradingsystem/getBHRating', $student->st_id, 4, $sy, $cl->bh_id);
    $averagePerQuarter = $firstbhg->row()->rate + $secondbhg->row()->rate + $thirdbhg->row()->rate + $fourthbhg->row()->rate;
    $avgbhg = getRating(round($averagePerQuarter/4,0,PHP_ROUND_HALF_DOWN));
    $pdf->setX(155);
    $pdf->MultiCell(45, 8, $t++ . '. ' . $cl->bh_name, 'RLB', 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($firstbhg->row()->rate != '' ? getRating($firstbhg->row()->rate) : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($secondbhg->row()->rate != '' ? getRating($secondbhg->row()->rate) : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($thirdbhg->row()->rate != '' ? getRating($thirdbhg->row()->rate) : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(7, 8, ($fourthbhg->row()->rate != '' ? getRating($fourthbhg->row()->rate) : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 8, $avgbhg, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->Ln();
endforeach;

$pdf->SetXY(250, 27);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(40, 5, 'GUIDELINES FOR RATING', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetXY(250, 32.5);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'Outstanding', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 40);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'A', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 50);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'Very Good', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 58);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'B', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 68);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'Good', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 76);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'C', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 86);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'Fair', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 94);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'D', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 104);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'Poor', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(250, 112);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(40, 10, 'E', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES . '/pilgrim.jpg';
$pdf->Image($image_file, 65, 25, 160, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);


