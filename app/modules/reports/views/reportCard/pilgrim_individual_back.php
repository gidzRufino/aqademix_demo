<?php

$subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);

$coreSubsFSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 1, $student->strnd_id, 1);
$appliedSubsFSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 1, $student->strnd_id);

$coreSubsSSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 2, $student->strnd_id, 1);
$appliedSubsSSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 2, $student->strnd_id);

$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('helvetica', 'B', 8);


//left column

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetY(8);
$pdf->MultiCell(148, 0, 'REPORT ON LEARNER\'S PROGRESS AND ACHIEVEMENT', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
// THIS IS THE LEFT SIDE
$pdf->SetX(10);
$pdf->Ln(8);

$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(10);
$pdf->MultiCell(45, 11, 'SUBJECTS', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(40, 5, 'Quarter', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(23, 11, 'Final Grade', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(25, 11, 'Remarks', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->Ln();
$pdf->SetXY(55, 28);
$pdf->MultiCell(10, 5, '1', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '2', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(10, 5, '3', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '4', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();

$fMapeh1 = 0;
$fMapeh2 = 0;
$fMapeh3 = 0;
$fMapeh4 = 0;
$finalGrade = 0;
$tSubj = 0;

foreach ($subject as $m):
    $singleSub = Modules::run('academic/getSpecificSubjects', $m->sub_id);
    if ($singleSub->parent_subject == 11):
        $mapeh1 = Modules::run('gradingsystem/getFinalGrade', $student->uid, $m->sub_id, 1, $sy);
        $mapeh2 = Modules::run('gradingsystem/getFinalGrade', $student->uid, $m->sub_id, 2, $sy);
        $mapeh3 = Modules::run('gradingsystem/getFinalGrade', $student->uid, $m->sub_id, 3, $sy);
        $mapeh4 = Modules::run('gradingsystem/getFinalGrade', $student->uid, $m->sub_id, 4, $sy);

        $fMapeh1 += $mapeh1->row()->final_rating;
        $fMapeh2 += $mapeh2->row()->final_rating;
        $fMapeh3 += $mapeh3->row()->final_rating;
        $fMapeh4 += $mapeh4->row()->final_rating;
    endif;
endforeach;

foreach ($subject as $s) {
    $pdf->SetX(10);
    $singleSub      = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $finalFirst     = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $finalSecond    = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $finalThird     = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $finalFourth    = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
    if ($singleSub->parent_subject == 11):
        $pdf->SetFont('helvetica', 'N', 7);
        if ($singleSub->subject_id == 13):  // MAPEH
            $tSubj++;
            $mapeh1Ave = (round($fMapeh1 / 4, 0)<=70?70:round($fMapeh1 / 4, 0));
            $mapeh2Ave = (round($fMapeh2 / 4, 0)<=70?70:round($fMapeh2 / 4, 0));
            $mapeh3Ave = (round($fMapeh3 / 4, 0)<=70?70:round($fMapeh3 / 4, 0));
            $mapeh4Ave = (round($fMapeh4 / 4, 0)<=70?70:round($fMapeh4 / 4, 0));
            $pdf->MultiCell(45, 5, '   MAPEH', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, $mapeh1Ave, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, $mapeh2Ave, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, $mapeh3Ave, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, $mapeh4Ave, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $genMapeh = round(($mapeh1Ave+$mapeh2Ave+$mapeh3Ave+$mapeh4Ave)/ 4, 0);
            $genMapeh = ($genMapeh<=70?70:$genMapeh);
            
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->MultiCell(23, 5, $genMapeh, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(25, 5, ($genMapeh >= 75?"PASSED":"FAILED"), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->Ln();
            $finalGrade += $genMapeh;
        endif;

        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'N', 7);
        $pdf->MultiCell(45, 5, '       ' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalFirst->row() ? ($finalFirst->row()->final_rating < 70?70:$finalFirst->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalSecond->row() ? ($finalSecond->row()->final_rating < 70?70:$finalSecond->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalThird->row() ? ($finalThird->row()->final_rating < 70?70:$finalThird->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalFourth->row() ? ($finalFourth->row()->final_rating < 70?70:$finalFourth->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 7);
        $subjectAverage = ($finalFourth->row() ? round((($finalFirst->row()->final_rating < 70?70:$finalFirst->row()->final_rating) + ($finalSecond->row()->final_rating < 70?70:$finalSecond->row()->final_rating) + ($finalThird->row()->final_rating < 70?70:$finalThird->row()->final_rating) + ($finalFourth->row()->final_rating < 70?70:$finalFourth->row()->final_rating)) / 4, 0) : 0);
        //$pdf->MultiCell(23, 5, 0, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(23, 5, ($finalFourth->row() ? $subjectAverage < 70?70:$subjectAverage:''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(25, 5,($subjectAverage >= 75?"PASSED":"FAILED") , 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
    else:
        $tSubj++;
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'N', 7);
        $pdf->MultiCell(45, 5, '   ' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalFirst->row() ? ($finalFirst->row()->final_rating < 70?70:$finalFirst->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalSecond->row() ? ($finalSecond->row()->final_rating < 70?70:$finalSecond->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalThird->row() ? ($finalThird->row()->final_rating < 70?70:$finalThird->row()->final_rating) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ($finalFourth->row() ? ($finalFourth->row()->final_rating < 70?70:$finalFourth->row()->final_rating ): ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 7); 
        $subjectAverage = ($finalFourth->row() ? round((($finalFirst->row()->final_rating < 70?70:$finalFirst->row()->final_rating) + ($finalSecond->row()->final_rating < 70?70:$finalSecond->row()->final_rating) + ($finalThird->row()->final_rating < 70?70:$finalThird->row()->final_rating) + ($finalFourth->row()->final_rating < 70?70:$finalFourth->row()->final_rating)) / 4, 0) : 0);
        $pdf->MultiCell(23, 5, ($finalFourth->row() ? $subjectAverage < 70?70:$subjectAverage : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(25, 5,($subjectAverage >= 75?"PASSED":"FAILED") , 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        
        $finalGrade += $subjectAverage;
    endif;
}
$specialClass = Modules::run('sf10/checkSpecialClass', $student->st_id, $sy, 1);
if($specialClass->num_rows() > 0):
    foreach($specialClass->result() as $spSub):
        $fsSub++;
        $singleSub = Modules::run('academic/getSpecificSubjects', $spSub->subject_id);
        $firstGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 1, $sy); 
        $secondGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 2, $sy); 
        $thirdGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 3, $sy); 
        $fourthGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 4, $sy); 
        $finalAverage = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 0, $sy); 
        
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'N', 7);
        $pdf->MultiCell(45, 5,'   '.$singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $tSubj++;
        if($firstGrade->row()->final_rating!=""):
            $pdf->MultiCell(10, 5, ($firstGrade->row()?$firstGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($secondGrade->row()?$secondGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($thirdGrade->row()?$thirdGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, ($fourthGrade->row()?$fourthGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->MultiCell(23, 5, ($finalAverage->row()?$finalAverage->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(25, 5, ( ($finalAverage->row()?$finalAverage->row()->final_rating:'')>=75?"PASSED":"FAILED"),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $finalGrade += $finalAverage->row()->final_rating;
            
        else:
            $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        endif; 
        
        $addRowValue += 4;
        $pdf->Ln();
    endforeach;
    
endif;

$pdf->SetX(10);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(55, 5, 'General Average', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(23, 5, ($finalGrade != 0 ? (round(($finalGrade) / ($tSubj), 0) < 70?70:round(($finalGrade) / ($tSubj), 0)) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, ($finalGrade != 0 ? (round(($finalGrade) / ($tSubj), 0) >= 75?"PASSED":"FAILED") : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(25, 5, $finalGrade, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$generalFinal = round(($finalGrade) / ($tSubj), 0);
   
        if (!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
            if ($generalFinal != ""):
                Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinal, $sy);
            endif;
        endif;
//Start of right Column
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetXY(145, 8);
$pdf->MultiCell(0, 10, 'REPORTS ON LEARNER\'S OBSERVED VALUES', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetX(155);
$pdf->MultiCell(40, 10.5, 'Core Values', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 10.5, 'Behavior Statements', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(44, 5, 'Quarter', 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetXY(245, 28);
$pdf->MultiCell(11, 5, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'N', 8);

function getRating($rate) {
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

        default :
            $star = '';
            break;
    }
    return $star;
}

$coreValues = Modules::run('gradingsystem/getCoreValues');

foreach ($coreValues as $cv):

    $customList = Modules::run('gradingsystem/getBehaviorRate', $cv->core_id);
    $customCount = count($customList->result());
    $rowCount = $customCount * 13;
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setX(155);
    $pdf->MultiCell(40, $rowCount, $cv->core_values, 'RLB', 'C', 0, 0, '', '', true, 0, false, true, $rowCount, 'M');
    foreach ($customList->result() as $cl):
        $firstbhg = Modules::run('gradingsystem/getBHRating', $student->st_id, 1, $sy, $cl->bh_id);
        $secondbhg = Modules::run('gradingsystem/getBHRating', $student->st_id, 2, $sy, $cl->bh_id);
        $thirdbhg = Modules::run('gradingsystem/getBHRating', $student->st_id, 3, $sy, $cl->bh_id);
        $fourthbhg = Modules::run('gradingsystem/getBHRating', $student->st_id, 4, $sy, $cl->bh_id);


        $pdf->SetFont('helvetica', 'N', 8);
        $pdf->setX(195);
        $pdf->MultiCell(50, 13, $cl->bh_name, 'RB', 'L', 0, 0, '', '', true, 0, false, true, 13, 'T');
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(11, 13, ($firstbhg->row() ? $firstbhg->row()->transmutation : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
        $pdf->MultiCell(11, 13, ($secondbhg->row() ? $secondbhg->row()->transmutation : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
        $pdf->MultiCell(11, 13, ($thirdbhg->row() ? $thirdbhg->row()->transmutation : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
        $pdf->MultiCell(11, 13, ($fourthbhg->row() ? $fourthbhg->row()->transmutation : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');

        $pdf->Ln();
    endforeach;

endforeach;

$pdf->SetX(155);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(0, 5, 'Observed Values', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4.5);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'Marking', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Non-Numerical Rating', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'AO', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Always Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'SO', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Sometimes Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'RO', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Rarely Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'NO', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Not Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetX(155);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(0, 5, 'Learner Progress and Achievement', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4.5);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'Descriptors', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Grading Scale', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Remarks', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'Outstanding', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '90-100', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Passed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'Very Satisfactory', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '85-89', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Passed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'Satisfactory', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '80-84', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Passed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'Fairly Satisfactory', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '75-89', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Passed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(40, 5, 'Did not Meet Expectations', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Below 75', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Failed', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES . '/pilgrim.jpg';
$pdf->Image($image_file, 65, 25, 160, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);