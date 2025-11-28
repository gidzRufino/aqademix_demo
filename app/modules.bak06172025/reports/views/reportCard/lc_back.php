<?php
function getDescriptor($number_grade)
{
    if($number_grade>=90):
            $letter = 'O';
        elseif($number_grade<90 && $number_grade>=85):
            $letter = 'VS';
        elseif($number_grade<85 && $number_grade>=80):
            $letter = 'S';
        elseif($number_grade<80 && $number_grade>=75):
            $letter = 'FS'; 
        else:
            $letter = 'F';
        endif;
        
        return $letter;
}
$coreValues = Modules::run('gradingsystem/getCoreValues');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetXY(145,189);
$pdf->StartTransform();
$pdf->Rotate(90);
foreach (array_reverse($coreValues, TRUE) as $core):
    
    switch ($core->core_id):
        case 1:
            $h = 40.5;
        break;
        case 2:
            $h = 32.5;
        break;
        case 3:
            $h = 32.5;
        break;
        case 4:
            $h = 32.5;
        break;
        default:    
            $h = 39;
        break;    
    endswitch;
    $pdf->MultiCell($h, 13, strtoupper($core->core_values),($core->core_id==1?'TRB':1), 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
endforeach;

$pdf->StopTransform();

$pdf->SetFont('helvetica', 'B', 8);


$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 

if(count($subject_ids)!=12):
    $pdf->SetXY(54.9,117.5);
else:
    $pdf->SetXY(54.9,112);
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
$pdf->MultiCell(18,8, 'Total',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

$pdf->StopTransform();


//left column

$pdf->SetY(8);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(10);
$pdf->MultiCell(30, 10.5, 'SUBJECTS',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40 , 5, 'PERIODICAL RATING','LTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(20 , 10.5, 'FINAL RATING',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(24 , 10.5, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetXY(40, 13);
$pdf->MultiCell(10, 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();

//$subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
//$subject = explode(',', $subject_ids->subject_id);
$i=0;

$mp = 0;
foreach($subject_ids as $sp):
    $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
    $final1 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 1, $sy); 
    $final2 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 2, $sy); 
    $final3 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 3, $sy); 
    $final4 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 4, $sy); 

    switch (TRUE):
        case $singleSub->parent_subject==18:
            $grd1 += $final1->row()->final_rating;
            $grd2 += $final2->row()->final_rating;
            $grd3 += $final3->row()->final_rating;
            $grd4 += $final4->row()->final_rating;
            $mp+=1;
        break; 
        case $student->grade_id>=5 && $student->grade_id<=7:
            if($singleSub->subject_id==51):
                $tle1 = $final1->row()->final_rating * .5;
                $tle2 = $final2->row()->final_rating * .5;
                $tle3 = $final3->row()->final_rating * .5;
                $tle4 = $final4->row()->final_rating * .5;
            elseif($singleSub->subject_id==5):
                $comp1 = $final1->row()->final_rating * .5;
                $comp2 = $final2->row()->final_rating * .5;
                $comp3 = $final3->row()->final_rating * .5;
                $comp4 = $final4->row()->final_rating * .5;
            endif;
        break;    
        case $student->grade_id==8:
        case $student->grade_id==9:
            if($singleSub->subject_id==10):
                $tle1 = $final1->row()->final_rating * .6;
                $tle2 = $final2->row()->final_rating * .6;
                $tle3 = $final3->row()->final_rating * .6;
                $tle4 = $final4->row()->final_rating * .6;
            elseif($singleSub->subject_id==5):
                $comp1 = $final1->row()->final_rating * .4;
                $comp2 = $final2->row()->final_rating * .4;
                $comp3 = $final3->row()->final_rating * .4;
                $comp4 = $final4->row()->final_rating * .4;
            endif;
        break;    
        case $student->grade_id==10:
        case $student->grade_id==11:
            if($singleSub->subject_id==10):
                $tle1 = $final1->row()->final_rating * .5;
                $tle2 = $final2->row()->final_rating * .5;
                $tle3 = $final3->row()->final_rating * .5;
                $tle4 = $final4->row()->final_rating * .5;
            elseif($singleSub->subject_id==5):
                $comp1 = $final1->row()->final_rating * .5;
                $comp2 = $final2->row()->final_rating * .5;
                $comp3 = $final3->row()->final_rating * .5;
                $comp4 = $final4->row()->final_rating * .5;
            endif;
        break;    
    endswitch;


    $tleComs1 = round(($tle1 + $comp1), 0, PHP_ROUND_HALF_UP);
    $tleComs2 = round(($tle2 + $comp2), 0, PHP_ROUND_HALF_UP);
    $tleComs3 = round(($tle3 + $comp3), 0, PHP_ROUND_HALF_UP);
    $tleComs4 = round(($tle4 + $comp4), 0, PHP_ROUND_HALF_UP);
    
    $tleCom1 = $tleComs1<=73?73:$tleComs1==74?75:$tleComs1;
    $tleCom2 = $tleComs2<=73?73:$tleComs2==74?75:$tleComs2;
    $tleCom3 = $tleComs3<=73?73:$tleComs3==74?75:$tleComs3;
    $tleCom4 = $tleComs4<=73?73:$tleComs4==74?75:$tleComs4;
    
    $tleComAve = round(($tleCom1+$tleCom2+$tleCom3+$tleCom4)/4, 0, PHP_ROUND_HALF_UP);

endforeach;
$finG1 = round($grd1/$mp);
$finG2 = round($grd2/$mp);
$finG3 = round($grd3/$mp);
$finG4 = round($grd4/$mp);

$finGAve = round(($finG1+$finG2+$finG3+$finG4)/4, 0, PHP_ROUND_HALF_UP);

$grd = 0;

$m = 0;
$tc = 0;
$numSubs=0;
$numSubsForAve = 0;
$fAve = 0;
foreach($subject_ids as $s){
       $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
       $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
       $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
       $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
       $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
   

        if($s->sub_id!=20):
            $i++;
            $firstFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating;
            $secondFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating ;
            $thirdFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy)->row()->final_rating ;
            $fourthFinal += Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy)->row()->final_rating ;
        endif;
        $finalAverage = round(($fg->row()->final_rating+$sg->row()->final_rating+$tg->row()->final_rating+$frg->row()->final_rating)/4,0, PHP_ROUND_HALF_UP);
        
    $pdf->SetFont('helvetica', 'N', 8);
    switch (TRUE):
        case $singleSub->parent_subject==10:
            $tleComTitle = ($student->grade_id>=8 && $student->grade_id<=11?'TLE / Computer':'EPP / Computer');
            $tc++;
            if($tc==1):
                $numSubsForAve++;  
                
                $fAve = $tleComAve;
                $pdf->SetX(10);
                $pdf->MultiCell(30, 5, '   '.$tleComTitle,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
                $pdf->MultiCell(10, 5, $tleCom1,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
                $pdf->MultiCell(10, 5, $tleCom2,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(10, 5, $tleCom3,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(10, 5, $tleCom4,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->MultiCell(10 , 5, $tleComAve,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(10 , 5, getDescriptor($tleComAve),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(24, 5, ($tleComAve>=75?"PASSED":"FAILED"),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->Ln();
                 $tleComAve = 0;
            endif;    
        break;
        case $singleSub->parent_subject==18:
            $m++;
            if($m==1):
                $numSubsForAve++;
                $pdf->SetX(10);
                $pdf->SetFont('helvetica', 'N', 8);
                $pdf->MultiCell(30, 5, '   MAPEH',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
                $pdf->MultiCell(10, 5, $finG1,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
                $pdf->MultiCell(10, 5, $finG2,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(10, 5, $finG3,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(10, 5, $finG4,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->MultiCell(10 , 5, $finGAve,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(10 , 5, getDescriptor($finGAve),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(24, 5, ($finGAve>=75?"PASSED":"FAILED"),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->Ln();
                $fAve = $finGAve;
                
                $pdf->SetX(10);
                $pdf->SetFont('helvetica', 'N', 8);
                $pdf->MultiCell(30, 5, '        '. $singleSub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
                $pdf->MultiCell(10, 5, ($fg->row()?$fg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
                $pdf->MultiCell(10, 5, ($sg->row()?$sg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(10, 5, ($tg->row()?$tg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->MultiCell(10, 5, ($frg->row()?$frg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->MultiCell(10 , 5, $finalAverage,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(10 , 5, getDescriptor($finalAverage),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(24, 5, ($finalAverage>=75?"PASSED":"FAILED"),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                $pdf->Ln();
            else:
                if($singleSub->parent_subject!=10):
                    $pdf->SetX(10);
                    $pdf->SetFont('helvetica', 'N', 8);
                    $pdf->MultiCell(30, 5, '        '. $singleSub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(10, 5, ($fg->row()?$fg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
                    $pdf->MultiCell(10, 5, ($sg->row()?$sg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                    $pdf->MultiCell(10, 5, ($tg->row()?$tg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                    $pdf->MultiCell(10, 5, ($frg->row()?$frg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                    $pdf->SetFont('helvetica', 'B', 8);
                    $pdf->MultiCell(10 , 5, $finalAverage,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(10 , 5, getDescriptor($finalAverage),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(24, 5, ($finalAverage>=75?"PASSED":"FAILED"),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
                    $pdf->Ln();
                    
                endif;

            endif;
        break;            
        default:
            $numSubsForAve++;
            $pdf->SetX(10);
            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->MultiCell(30, 5, '   '. $singleSub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
            $pdf->MultiCell(10, 5, ($fg->row()?$fg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            $pdf->MultiCell(10, 5, ($sg->row()?$sg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(10, 5, ($tg->row()?$tg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(10, 5, ($frg->row()?$frg->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->MultiCell(10 , 5, $finalAverage,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10 , 5, getDescriptor($finalAverage),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(24, 5, ($finalAverage>=75?"PASSED":"FAILED"),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->Ln();
            if($singleSub->parent_subject!=10):
                $fAve = $finalAverage;
            endif;
        break;
    endswitch;
    $generalFinal += $fAve;
    $fAve = 0;
}	
    
    $pdf->SetX(10);
    $pdf->MultiCell(30, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(10 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(24, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    
    $pdf->Ln();
    
    
    $pdf->SetX(10);
    $pdf->MultiCell(30, 5, 'General Average',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    
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
            $generalFinal = round($generalFinal/$numSubsForAve,0,PHP_ROUND_HALF_UP);
            if($generalFinal<=75 && $generalFinal >=$settings->final_passing_mark):
                $generalFinal = $generalFinal;
            endif;
        else:
            $generalFinal = '';
        endif;

        $pdf->MultiCell(10, 5, round($firstFinal),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(10, 5, round($secondFinal),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(10, 5, round($thirdFinal),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(10, 5, round($fourthFinal),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(10 , 5,$generalFinal,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(10 , 5, getDescriptor($generalFinal),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(24, 5, ($generalFinal>=75?"PASSED":"FAILED"),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');

        
        if(!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
           Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinal, $sy); 
        endif;
  
     
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(10);
$pdf->SetX(15);
$pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Descriptors',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->MultiCell(30, 5, 'Grading Scale',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->MultiCell(30, 5, 'Remarks',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->MultiCell(10 , 5, 'O',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, 'OUTSTANDING',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, '90% & ABOVE',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');  
$pdf->MultiCell(30, 5, 'PASSED',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10 , 5, 'VS',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, 'VERY SATISFACTORY',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, '85% - 89%',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, 'PASSED',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10 , 5, 'S',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, 'SATISFACTORY',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, '80% - 84%',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, 'PASSED',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10 , 5, 'FS',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, 'FAIRLY SATISFACTORY',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, '75% - 79%',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, 'PASSED',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10 , 5, 'F',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, 'DID NOT MEET EXPECTATIONS',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, 'BELOW 75%',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
$pdf->MultiCell(30, 5, 'FAILED',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln(10.5);
//list of subjects
   
//
$sd = Modules::run('reports/getRawSchoolDays', $sy);
$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $student->st_id, $student->grade_id, $sy);

$tardyJune = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 6, $sy);
$tardyJul = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 7, $sy);
$tardyAug = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 8, $sy);
$tardySept = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 9, $sy);
$tardyOct = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 10, $sy);
$tardyNov = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 11, $sy);
$tardyDec = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 12, $sy);
$tardyJan = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 1, $sy);
$tardyFeb = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 2, $sy);
$tardyMar = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 3, $sy);
$tardyApr = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $student->st_id, 4, $sy);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(140, 0, 'ATTENDANCE RECORD',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(8);
$pdf->SetX(15);
$pdf->MultiCell(40, 18, '',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(40, 10, 'Days of School',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->June ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->July ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->August ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->September ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->October ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->November ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->December ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->January ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->February ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->March ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,$sd->row()->April ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10,$sd->row()->June+$sd->row()->July+$sd->row()->August+$sd->row()->September+$sd->row()->October+$sd->row()->November+$sd->row()->December+$sd->row()->January+$sd->row()->February+$sd->row()->March+$sd->row()->April ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(40, 10, 'Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->June<$attendance->June?$sd->row()->June:$attendance->June) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->July<$attendance->July?$sd->row()->July:$attendance->July) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->August<$attendance->August?$sd->row()->August:$attendance->August) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->September<$attendance->September?$sd->row()->September:$attendance->September) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->October<$attendance->October?$sd->row()->October:$attendance->October) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->November<$attendance->November?$sd->row()->November:$attendance->November) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->December<$attendance->December?$sd->row()->December:$attendance->December) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->January<$attendance->January?$sd->row()->January:$attendance->January) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->February<$attendance->February?$sd->row()->February:$attendance->February) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->March<$attendance->March?$sd->row()->March:$attendance->March) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10,($sd->row()->April<$attendance->April?$sd->row()->April:$attendance->April) ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10,$attendance->June+$attendance->July+$attendance->August+$attendance->September+$attendance->October+$attendance->November+$attendance->December+$attendance->January+$attendance->February+$attendance->March+$attendance->April ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(40, 10, 'Days Tardy',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyJune->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyJul->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyAug->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardySept->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyOct->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyNov->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyDec->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyJan->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyFeb->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyMar->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5.5, 10, $tardyApr->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, $tardyJune->num_rows()+$tardyJul->num_rows()+$tardyAug->num_rows()+$tardySept->num_rows()+$tardyOct->num_rows()+$tardyNov->num_rows()+$tardyDec->num_rows()+$tardyJan->num_rows()+$tardyFeb->num_rows()+$tardyMar->num_rows()+$tardyApr->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->Ln();


//right column

$pdf->SetXY(145, 8);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(13, 5.5, 'PROFILE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 5, 'CHAMPION\'S INDICATORS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'Q1',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'Q2',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'Q3',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'Q4',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();


function getRating($behaviorRating)
{
    $rate = $behaviorRating->rate;
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
            $star = 'SO';
        break;
    }
    return $star;
}


foreach ($bh_group as $bR):
    
    $bhrate1 = getRating(Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $student->st_id, $bR->bh_id, 1, $sy));
    $bhrate2 = getRating(Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $student->st_id, $bR->bh_id, 2, $sy));
    $bhrate3 = getRating(Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $student->st_id, $bR->bh_id, 3, $sy));
    $bhrate4 = getRating(Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $student->st_id, $bR->bh_id, 4, $sy));

    $pdf->SetFont('helvetica', 'N', 6.7);
    $pdf->SetX(158);
    $pdf->MultiCell(90, 6.5, $bR->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true,6.5, 'M');
    $pdf->SetFont('helvetica', 'B', 7.5);
    $pdf->MultiCell(7,6.5, $bhrate1,1, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
    $pdf->MultiCell(7,6.5, $bhrate2,1, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
    $pdf->MultiCell(7,6.5, $bhrate3,1, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
    $pdf->MultiCell(7, 6.5, $bhrate4,1, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
    $pdf->Ln();
endforeach;

$pdf->SetX(145);
$pdf->MultiCell(20,6.5, 'Marking',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->MultiCell(40,6.5, 'Non-numerical Rating',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->MultiCell(10,6.5, '',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->MultiCell(20,6.5, 'Marking',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->MultiCell(40, 6.5, 'Non-numerical Rating',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->Ln();
$pdf->SetX(145);
$pdf->MultiCell(20,6.5, 'AO',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->SetFont('helvetica', 'N', 7.5);
$pdf->MultiCell(40,6.5, 'Always Observed',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->MultiCell(10,6.5, '',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->SetFont('helvetica', 'B', 7.5);
$pdf->MultiCell(20,6.5, 'RO',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->SetFont('helvetica', 'N', 7.5);
$pdf->MultiCell(40, 6.5, 'Rarely Observed',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->Ln();
$pdf->SetX(145);
$pdf->SetFont('helvetica', 'B', 7.5);
$pdf->MultiCell(20,6.5, 'SO',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->SetFont('helvetica', 'N', 7.5);
$pdf->MultiCell(40,6.5, 'Somtimes Observed',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->SetFont('helvetica', 'B', 7.5);
$pdf->MultiCell(10,6.5, '',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->MultiCell(20,6.5, 'NO',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->SetFont('helvetica', 'N', 7.5);
$pdf->MultiCell(40, 6.5, 'Not Observed',0, 'C', 0, 0, '', '', true, 0, false, true,6.5, 'M');
$pdf->Ln();