<?php
function getMakabayan($pdf, $first, $second, $third, $fourth)
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
    
    $pdf->SetXY(15,55.5);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(40, 5, 'MAKABAYAN',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, $first,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, $second,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, $third,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, $fourth,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    if($macFinalAverage >= 75):
        $pdf->MultiCell(12, 5, $macFinalAverage,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
    else:
         $pdf->SetTextColor(255, 0, 0);
         $pdf->MultiCell(12, 5, $macFinalAverage,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
         $pdf->SetTextColor(000, 0, 0);

    endif; 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    if($macFinalAverage >= 75):
        $pdf->MultiCell(12, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
    else:
         $pdf->SetTextColor(255, 0, 0);
         $pdf->MultiCell(12, 5, 'Failed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
         $pdf->SetTextColor(000, 0, 0);

    endif;
    $pdf->Ln();
    $pdf->SetXY(15,89);
}
function getGrade($subject, $sub_id)
{
    if($sub_id!=20):
          $plg = Modules::run('gradingsystem/getEquivalent',round($subject->row()->final_rating, 1));
        else:
         $plg = Modules::run('gradingsystem/getBGBEquivalent',round($subject->row()->final_rating, 1))   ; 
            
        endif;
        
    if($subject->row()->final_rating==""):
        $plg = "";
    endif;

    return $plg;
}

function getFinalGrade($grade)
{
    $plg = Modules::run('gradingsystem/getLetterGrade', $grade);
    foreach($plg->result() as $plg){
        if( $grade >= $plg->from_grade && $grade <= $plg->to_grade){
            
      
                $grade = $plg->letter_grade;
           
            if($grade!="" || $grade!=0 || $grade < 60):
                $grade = $grade;
            else:
                $grade = "";
            endif;
        }
    }
    
    return $grade;
}

$pdf->SetY(3);
$pdf->SetFont('Times', 'BI', 10);
$pdf->MultiCell(300, 0, '"Train up a child in a way he should go so when he is old, he will not depart from it."',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);
$pdf->MultiCell(300, 0, 'Proverbs 22:6',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

//$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('helvetica', 'B', 8);
if($student->grade_id==1):
    $pdf->SetXY(59.9,110);
else:
    $pdf->SetXY(59.9,115.9);
endif;

$pdf->StartTransform();
$pdf->Rotate(90);
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'June',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'July',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'August',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'September',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'October',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'November',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'December',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'January',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'February',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'March',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'April',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 7, 'Total',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

$pdf->StopTransform();


//left column

$pdf->SetY(8);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(15);
$pdf->SetX(15);
$pdf->MultiCell(40, 10.5, 'SUBJECTS',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(48 , 5, 'PERIODICAL RATING','LTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(24 , 10.5, 'FINAL RATING',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(13 , 10.5, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetXY(55, 28);
$pdf->MultiCell(12, 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
//$subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
//$subject = explode(',', $subject_ids->subject_id);
$i=0;
foreach($subject_ids as $s){
    
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, $singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
    if(getGrade(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy))==""):
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    else:
       $units = $singleSub->unit_a;
      // $totalUnits += $units;
       $partialGrade = ($fg->row()->final_rating);
       $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
       $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
       $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
       $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
       
       if($s->sub_id!=20):
            $pdf->MultiCell(12, 5, $fg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            $pdf->MultiCell(12, 5, $sg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            $pdf->MultiCell(12, 5, $tg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            $pdf->MultiCell(12, 5, $frg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
        else:
            $pdf->MultiCell(12, 5, getFinalGrade($fg->row()->final_rating),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            $pdf->MultiCell(12, 5, getFinalGrade($sg->row()->final_rating),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            $pdf->MultiCell(12, 5, getFinalGrade($tg->row()->final_rating),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
            $pdf->MultiCell(12, 5, getFinalGrade($frg->row()->final_rating),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
       endif;
       
       

    endif;
    $first = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating;
    $second = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating;
    $third = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy)->row()->final_rating;
    $fourth = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy)->row()->final_rating;

    if($s->sub_id!=20):
        $i++;
        $firstFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating;
        $secondFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating ;
        $thirdFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy)->row()->final_rating ;
        $fourthFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy)->row()->final_rating ;
    endif;
    


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
            if($s->sub_id!=20):
                $pdf->MultiCell(24, 5,  round($finalAverage, 2).' / '.getFinalGrade(round($finalAverage, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            else:
                $pdf->MultiCell(24, 5,  getFinalGrade(round($finalAverage, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            endif;
            if($finalAverage >= $settings->final_passing_mark):
                $pdf->MultiCell(13, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
            else:
                 $pdf->SetTextColor(255, 0, 0);
                 $pdf->MultiCell(24, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                 $pdf->SetTextColor(000, 0, 0);

            endif;
        else:
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        endif;
        
    $pdf->Ln();
    

    if($s->sub_id!=20):
        $generalFinal += $finalAverage;
    endif;
}	
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(24 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    
    $pdf->Ln();
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, 'General Average',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    
        $firstFinal = $firstFinal/$i; 
        if(($secondFinal)==0):
            $secondFinal='';
        else:
            $secondFinal = $secondFinal/$i; 
        endif;
        if(($thirdFinal)==0):
            $thirdFinal='';
        else:
            $thirdFinal = $thirdFinal/$i; 
        endif;
        if(($fourthFinal)==0):
            $fourthFinal='';
        else:
           $fourthFinal = $fourthFinal/$i;  
        endif;
        
        if($fourthFinal!=0):
            $generalFinal = round($generalFinal/$i, 2);
            if($generalFinal<=75 && $generalFinal >=$settings->final_passing_mark):
                $generalFinal = $generalFinal.' / '.getFinalGrade(75);
            endif;
        else:
            $generalFinal = '';
        endif;

        $pdf->MultiCell(12, 5, $firstFinal,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(12, 5, $secondFinal,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(12, 5, $thirdFinal,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(12, 5, $fourthFinal,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(24 , 5,$generalFinal,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');

        
        if(!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
           Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinal, $sy); 
        endif;
  
    
    
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Ln(10);
        $pdf->SetX(20);
        $pdf->MultiCell(110, 5, 'Legend:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, 'Beginning (B)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(35, 5, '74% and Below',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, 'Developing (D)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(35, 5, '75% - 79%',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, 'Approaching Proficiency (AP)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(35, 5, '80% - 84%',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, 'Proficient (P)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(35, 5, '85% - 90%',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, 'Advanced (A)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(35, 5, '90% and above',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(15.5);
//list of subjects
   
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(148, 0, 'ATTENDANCE RECORD',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(8);
$pdf->SetX(20);
$pdf->MultiCell(40, 18, '',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(20);
$pdf->MultiCell(40, 10, 'Days of School',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$x = 5;
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    endif;
    $next = $sy+1;
    if($this->session->userdata('school_year')>$sy):
        if($m<abs(06)):
            $year = $next;
        else:
            $year = $sy;
        endif;
    else:
        if($m<abs(06) && date('Y')>$sy):
            $year = date('Y');
        else:
            $year = $sy;
        endif;
    endif;
    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year, $sy);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    $pdf->MultiCell(5.5, 10,$totalDaysInAMonth ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}

$pdf->MultiCell(7, 10, $totalDays,1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(20);
$pdf->MultiCell(40, 10, 'Days of Present',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    endif;
    if($m<abs(06) && date('Y')>$sy):
        $schoolYear = date('Y');
    else:
        $schoolYear = $sy;
    endif;
    
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;

            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
            else:    
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
            endif;
     if($sy==$schoolYear):
         if($pdays>0):
            $pdf->MultiCell(5.5, 10, $pdays,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
         else:
             $pdf->MultiCell(5.5, 10, 0,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
         endif;
      
     else:   
        if($pdays>0):
            $pdf->MultiCell(5.5, 10, $pdays,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
         else:
             $pdf->MultiCell(5.5, 10, 0 ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
         endif; 
     endif;
         
    $total_pdays += $pdays;
}

$pdf->MultiCell(7, 10, $total_pdays,1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M');

function getRating($behaviorRating)
{
    $rate = $behaviorRating->row()->rate;
    switch ($rate)
    {
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

   
//Start of right Column
$pdf->SetXY(145,8);
$pdf->setX(170);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(15);
$pdf->setX(170);
$pdf->MultiCell(50, 10.5, 'CHARACTER TRAITS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60 , 5.5, 'PERIODIC RATING','LTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->SetXY(220, 28);
$pdf->MultiCell(15 , 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(15 , 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(15 , 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(15 , 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();


    foreach($behaviorRate as $bhr):
        $pdf->SetFont('helvetica', 'N', 7);
        $pdf->setX(170);
        $pdf->MultiCell(50, 7, $bhr->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,1, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,2, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,3, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,4, $sy, $bhr->bh_id)),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->Ln();
        $pdf->SetX(195);
    endforeach;
    
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Ln(10);
        $pdf->SetX(170);
        $pdf->MultiCell(110, 5, 'Guide for Rating:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(180);
        $pdf->MultiCell(55, 5, 'A - Very Good',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(180);
        $pdf->MultiCell(55, 5, 'B - Good',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(180);
        $pdf->MultiCell(55, 5, 'C - Fair',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(180);
        $pdf->MultiCell(55, 5, 'D - Poor',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(5);