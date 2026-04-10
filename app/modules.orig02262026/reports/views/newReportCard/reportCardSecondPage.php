<?php

function transmuteGrade($grade)
{
    $plg = Modules::run('gradingsystem/new_gs/getTransmutation', $grade);
    return $plg;
}
function getGrade($subject)
{
    $plg = Modules::run('gradingsystem/getLetterGrade', $subject->row()->final_rating);
    foreach($plg->result() as $plg){
        if( $subject->row()->final_rating >= $plg->from_grade && $subject->row()->final_rating <= $plg->to_grade){
            
      
                $grade = $plg->letter_grade;
           
            if($grade!=""):
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
    if($second==0):
        $second='';
    endif;
    if($third==0):
        $third='';
    endif;
    if($fourth==0):
        $fourth='';
    endif;
    $macFinalAverage = ($first+$second+$third+$fourth)/4;
    
    $pdf->SetXY(10,72);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(40, 5, 'MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, round($second, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, round($third, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, round($fourth, 0, PHP_ROUND_HALF_UP), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    if ($term == 4):
    if($macFinalAverage >= 75):
        $pdf->MultiCell(24, 5, round($macFinalAverage, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
    else:
         $pdf->SetTextColor(255, 0, 0);
         $pdf->MultiCell(24, 5,  round($macFinalAverage, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
         $pdf->SetTextColor(000, 0, 0);

    endif; 
    if($macFinalAverage >= 75):
        $pdf->MultiCell(15, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
    else:
         $pdf->SetTextColor(255, 0, 0);
         $pdf->MultiCell(15, 5, 'Failed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
         $pdf->SetTextColor(000, 0, 0);

    endif;
  else:
        $pdf->MultiCell(24, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
      
  endif;
    $pdf->Ln();
    $pdf->SetXY(15,89);
}


$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('helvetica', 'B', 8);


//left column

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetY(8);
$pdf->MultiCell(148, 0, 'REPORT ON LEARNER\'S PROGRESS AND ACHIEVEMENT',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(15);
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(57, 10.5, 'Learning Areas', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 5, 'Quarter', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 10.5, 'Final Grade', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10.5, 'Remarks', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln();
$pdf->SetXY(67, 28);
$pdf->MultiCell(10, 5, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
$q = 1;

$pdf->SetFont('times', 'R', 8);
$pdf->SetFillColor(225, 225, 225);
foreach ($subject_ids as $s) {
    $pdf->SetX(10);
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
    if ($singleSub->parent_subject == 11):
        if ($q == 1):
            $pdf->MultiCell(57, 5, 'MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh1 != 0 ? $mapeh1 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh2 != 0 ? $mapeh2 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh3 != 0 ? $mapeh3 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($mapeh4 != 0 ? $mapeh4 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            //        $pdf->MultiCell(10, 5, ($finalMAPEH != 0 ? $finalMAPEH : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, ($mapeh4 != 0 ? number_format($finalMAPEH, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, ($mapeh4 != 0 ? ($finalMAPEH < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
        $pdf->MultiCell(15, 5, ($frg->row()->final_rating != 0 ? number_format($finRateNum, 2) : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, ($frg->row()->final_rating != 0 ? ($finRateNum < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $q++;
    else:
        $subCount++;
        $pdf->MultiCell(57, 5, ($s->sub_id != 218876 ? $singleSub->subject : 'GMRC / CFC'), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $finRateNum = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row()->final_rating + $frg->row()->final_rating) / 4, 2);
        $pdf->MultiCell(15, 5, ($frg->row()->final_rating != 0 ? number_format($finRateNum, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, ($frg->row()->final_rating != 0 ? ($finRateNum < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
$pdf->MultiCell(15, 5, ($aveFourth != 0 ? number_format($aveFinRate, 2) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, ($aveFourth != 0 ? ($aveFinRate < 75 ? 'Failed' : 'Passed') : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
// getMAPEH($pdf, $mapeh1, $mapeh2, $mapeh3, $mapeh4, $term);


$pdf->Ln(40);
    $pdf->SetX(20);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(40, 5, 'Descriptors',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Grading Scale',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Remarks',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(20);
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->MultiCell(40, 5, 'Outstanding',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '90-100',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(20);
    $pdf->MultiCell(40, 5, 'Very Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '85-89',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(20);
    $pdf->MultiCell(40, 5, 'Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '80-84',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(20);
    $pdf->MultiCell(40, 5, 'Fairly Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '75-89',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(20);
    $pdf->MultiCell(40, 5, 'Did not Meet Expectations',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Below 75',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Failed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

//Start of right Column
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetXY(145,8);
$pdf->MultiCell(0, 10, 'REPORTS ON LEARNER\'S OBSERVED VALUES',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 10.5, 'Core Values',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 10.5, 'Behavior Statements',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 5, 'Quarter','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetXY(245,28);
    $pdf->MultiCell(10, 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    
    $pdf->SetFont('helvetica', 'N', 8);
    
function getRating($behaviorRating)
{
    $rate = $behaviorRating->row()->rate;
    switch ($rate)
    {
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
     
        default :
            $star = '';
        break;
    }
    return $star;
}

$baseLineHeight = 5;
$pdf->setCellPaddings(1, 1, 1, 1);

$col3Width = 40;
$subColW   = $col3Width / 4;

foreach ($bh_group as $bhg):

    $bhRate = Modules::run('reports/getBhRate', $bhg->core_id, 1);
    if (empty($bhRate)) {
        continue;
    }

    $startY      = $pdf->GetY();
    $currentY    = $startY;
    $totalHeight = 0;

    /**
     * PRE-CALCULATE TOTAL HEIGHT (based on column 2)
     */
    $rowHeights = [];

    foreach ($bhRate as $bhr) {
        $lines = $pdf->getNumLines($bhr->bh_name, 50);
        $rowH  = max($baseLineHeight, $lines * $baseLineHeight);
        $rowHeights[] = $rowH;
        $totalHeight += $rowH;
    }

    /**
     * COLUMN 1 (grouped)
     */
    $pdf->SetXY(155, $startY);
    $pdf->MultiCell(40, $totalHeight, $bhg->core_values, 1, 'C', false, 0, '', '', true, 0, false, true, $totalHeight, 'M');

    /**
     * COLUMN 2 + COLUMN 3 (row-by-row)
     */
    foreach ($bhRate as $index => $bhr) {

        $rowH = $rowHeights[$index];

        /**
         * COLUMN 2
         */
        $pdf->SetXY(195, $currentY);
        $pdf->MultiCell(50, $rowH, $bhr->bh_name, 1, 'C', false, 0, '', '', true, 0, false, true, $rowH, 'M');

        /**
         * COLUMN 3 (split into 4)
         */
        $x = 245;
        for ($i = 0; $i < 4; $i++) {
            $rating = Modules::run('gradingsystem/getBHRating', $student->uid, ($i + 1), $sy, $bhr->bh_id);
            if ($rating->num_rows() > 0):
                switch ($rating->row()->rate):
                    case 1:
                        $rate = 'NO';
                        break;
                    case 2:
                        $rate = 'RO';
                        break;
                    case 3:
                        $rate = 'SO';
                        break;
                    case 4:
                        $rate = 'AO';
                        break;
                endswitch;
            else:
                $rate = '';
            endif;
            $pdf->SetXY($x + ($subColW * $i), $currentY);
            $pdf->MultiCell($subColW, $rowH, $rate, 1, 'C', false, 0, '', '', true, 0, false, true, $rowH, 'M');
        }

        $currentY += $rowH;
    }

    // Move cursor below the block
    $pdf->SetY($startY + $totalHeight);

endforeach;


// foreach($bh_group as $bhg):
//     $bhRate = Modules::run('reports/getBhRate', $bhg->core_id, 1);
//     $tbh = count($bhRate);
//     $pdf->SetX(155);
//     $pdf->MultiCell(40, (9 * $tbh), $bhg->core_values,1, 'C', 0, 0, '', '', true, 0, false, true, (9 * $tbh), 'M');
//     foreach($bhRate as $bhr):
//         $pdf->SetX(195);
//         $pdf->MultiCell(50, 8, $bhr->bh_name,1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');   
//         $pdf->MultiCell(40, 8, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'T');
//         $pdf->Ln();
//     endforeach; 
// endforeach;

//     foreach($bh_group as $bhg):
//         switch ($bhg->core_id):
//             case 1:
//                 $group = 'MAKA 
// DIYOS';
//                 $pdf->SetX(155);
//                 $pdf->MultiCell(40, 30, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
//                 $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

//                 foreach($bhRate as $bhr):
//                     $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->Ln();
//                     $pdf->SetX(195);
//                 endforeach;

//             break;
//             case 2:
//                 $group = 'MAKATAO';

//                 $pdf->SetX(155);
//                 $pdf->MultiCell(40, 30, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
//                 $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

//                 foreach($bhRate as $bhr):
//                     $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->Ln();
//                     $pdf->SetX(195);
//                 endforeach;
//             break;
//             case 3:
//                 $group = 'MAKA 
// KALIKASAN';
//                $pdf->SetX(155);
//                 $pdf->MultiCell(40, 15, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                 $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

//                 foreach($bhRate as $bhr):
//                     $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');           
//                     $pdf->Ln();
//                     $pdf->SetX(195);
//                 endforeach; 
//             break;
//             case 4:
//                 $group = 'MAKA 
// BANSA';
//                 $pdf->SetX(155);
//                 $pdf->MultiCell(40, 30, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
//                 $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

//                 foreach($bhRate as $bhr):
//                     $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
//                     $pdf->Ln();
//                     $pdf->SetX(195);
//                 endforeach;
//             break;
//         endswitch;

//     endforeach;


$pdf->Ln(10);
    $pdf->SetX(150);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(40, 5, 'Marking',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Non-Numerical Rating',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(150);
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->MultiCell(40, 5, 'AO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Always Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(150);
    $pdf->MultiCell(40, 5, 'SO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Sometimes Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(150);
    $pdf->MultiCell(40, 5, 'RO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Rarely Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(150);
    $pdf->MultiCell(40, 5, 'NO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Not Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    