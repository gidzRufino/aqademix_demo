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
    $pdf->MultiCell(40, 5, 'MAPEH',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    switch ($term):
            case 1:
                $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            break;
            case 2:
                $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, round($second, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            break;
            case 3:
                $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, round($second, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, round($third, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            break;
            case 4:
                $pdf->MultiCell(12, 5, round($first, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, round($second, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, round($third, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(12, 5, round($fourth, 0, PHP_ROUND_HALF_UP),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            break;
                
        endswitch;
   if($term==4):
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
$pdf->MultiCell(40, 10.5, 'Learning Areas',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(48 , 5, 'Quarter','LTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(24 , 10.5, 'Final Grade',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15 , 10.5, 'Remarks',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln();
$pdf->SetXY(50, 28);
$pdf->MultiCell(12, 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();

$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
//$subject = explode(',', $subject_ids->subject_id);
$i=0;
foreach($subject_ids as $s){
    $i++;
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $pdf->SetX(10);
    switch ($i):
        case 8:
        case 9:
        case 10:
        case 11:
            $pdf->MultiCell(40, 5,'     '.$singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        break;
        default :
            $pdf->MultiCell(40, 5, $singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        break;
    endswitch;
    
	$fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
        switch ($term):
            case 1:
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            break;
            case 2:
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            break;
            case 3:
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            break;
            case 4:
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
                $pdf->MultiCell(12, 5, transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy)->row()->final_rating, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            break;
                
        endswitch;
           

        $first = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating;
        $second = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating;
        $third = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy)->row()->final_rating;
        $fourth = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy)->row()->final_rating;
        
        $m1 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 13, 1, $sy)->row()->final_rating, 2));
        $a1 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 14, 1, $sy)->row()->final_rating, 2));
        $pe1 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 15, 1, $sy)->row()->final_rating, 2));
        $h1 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 16, 1, $sy)->row()->final_rating, 2));
        $mapeh1 = ($m1 + $a1 + $pe1 + $h1)/4;
        if($mapeh1==0):$mapeh1=""; endif;
        
        $m2 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 13, 2, $sy)->row()->final_rating, 2));
        $a2 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 14, 2, $sy)->row()->final_rating, 2));
        $pe2 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 15, 2, $sy)->row()->final_rating, 2));
        $h2= transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 16, 2, $sy)->row()->final_rating, 2));
        $mapeh2 = ($m2 + $a2 + $pe2 + $h2)/4;
        if($mapeh2==0):$mapeh2=""; endif;
        
        $m3 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 13, 3, $sy)->row()->final_rating, 2));
        $a3 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 14, 3, $sy)->row()->final_rating, 2));
        $pe3 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 15, 3, $sy)->row()->final_rating, 2));
        $h3= transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 16, 3, $sy)->row()->final_rating, 2));
        $mapeh3 = ($m3 + $a3 + $pe3 + $h3)/4;
        if($mapeh3==0):$mapeh3=""; endif;
        
        $m4 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 13, 4, $sy)->row()->final_rating, 2));
        $a4 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 14, 4, $sy)->row()->final_rating, 2));
        $pe4 = transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 15, 4, $sy)->row()->final_rating, 2));
        $h4= transmuteGrade(round(Modules::run('gradingsystem/getFinalGrade', $student->uid, 16, 4, $sy)->row()->final_rating, 2));
        $mapeh4 = ($m4 + $a4 + $pe4 + $h4)/4;
        if($mapeh4==0):$mapeh4=""; endif;
        
    if($s->sub_id==17):
        if(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy)->row()->final_rating!=0):
            $pdf->MultiCell(12, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        else:
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        endif;
        $pdf->MultiCell(12, 5, $singleSub->unit_a,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        $finalAverage = ($first+$second+$third+$fourth)/4;
        if($finalAverage<=75 && $finalAverage >= $settings->final_passing_mark):
            $finalAverage = 75;
        endif;
        
        Modules::run('gradingsystem/saveGeneralAverage', $student->section_id, $student->uid, $s->sub_id, $sy, $finalAverage);
            $finalAverage = ($first+$second+$third+$fourth)/4;
            if($finalAverage<=75 && $finalAverage >= $settings->final_passing_mark):
                $finalAverage = 75;
            endif;
            if($fourth!=0):
                $pdf->MultiCell(24, 5, transmuteGrade(round($finalAverage, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                if($finalAverage >= $settings->final_passing_mark):
                    $pdf->MultiCell(15, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                else:
                     $pdf->SetTextColor(255, 0, 0);
                     $pdf->MultiCell(24, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                     $pdf->SetTextColor(000, 0, 0);

                endif;
            else:
                $pdf->MultiCell(24, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            endif;
        
    endif;
    
    
    if($i==7): 
        $pdf->Ln();
    endif; 
        
    $pdf->Ln();
    

    $generalFinal += $finalAverage;
}
    getMAPEH($pdf, $mapeh1, $mapeh2, $mapeh3, $mapeh4, $term);
	
    $pdf->Ln(11);
    $pdf->SetX(10);
    $pdf->MultiCell(40, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(24 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    //$pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetX(10);
    $pdf->MultiCell(40, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
 
//
        
        $generalFinal = round($generalFinal/$i, 2);
        if($generalFinal<=75 && $generalFinal >=$settings->final_passing_mark):
            $generalFinal = 75;
        endif;

        $pdf->MultiCell(48, 5, 'General Average',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        if($term!=4):
             $pdf->MultiCell(24 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        else:    
            $pdf->MultiCell(24 , 5, transmuteGrade($generalFinal),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
//        $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M
        
        if(!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
           Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinal, $sy); 
        endif;

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
    
    foreach($bh_group as $bhg):
        switch ($bhg->bh_group):
            case 1:
                $group = 'MAKA 
DIYOS';
                $pdf->SetX(155);
                $pdf->MultiCell(40, 30, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
                $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

                foreach($bhRate as $bhr):
                    $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->Ln();
                    $pdf->SetX(195);
                endforeach;
            
            break;
            case 2:
                $group = 'MAKATAO';
                
                $pdf->SetX(155);
                $pdf->MultiCell(40, 30, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
                $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

                foreach($bhRate as $bhr):
                    $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->Ln();
                    $pdf->SetX(195);
                endforeach;
            break;
            case 3:
                $group = 'MAKA 
KALIKASAN';
               $pdf->SetX(155);
                $pdf->MultiCell(40, 15, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

                foreach($bhRate as $bhr):
                    $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');           
                    $pdf->Ln();
                    $pdf->SetX(195);
                endforeach; 
            break;
            case 4:
                $group = 'MAKA 
BANSA';
                $pdf->SetX(155);
                $pdf->MultiCell(40, 30, $group,1, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
                $bhRate = Modules::run('reports/getBhRate', $bhg->bh_group);

                foreach($bhRate as $bhr):
                    $pdf->MultiCell(50, 15, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->MultiCell(10, 15, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    $pdf->Ln();
                    $pdf->SetX(195);
                endforeach;
            break;
        endswitch;
        
    endforeach;
    
    
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
    
    