<?php
//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('Y-m-d',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->cal_date;
//    $from = new DateTime($bdate);
//    $to   = new DateTime($firstFridayOfJune);
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[1];
    $d = $bdateItems[2];
    $y = $bdateItems[0];
    
    
    if(abs(date('m')<$m)){
        $yearsOfAge  = ((date('Y') - date('Y',strtotime($bdate))))-1;
        
    }else{
        $yearsOfAge = (date('Y') - date('Y',strtotime($bdate)));
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
$settings = Modules::run('main/getSet');
$pdf->SetY(3);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->MultiCell(300, 0,ucfirst($settings->set_school_name),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(300, 0, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


//left column

$pdf->SetY(1);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(13);
$pdf->SetX(5);
$pdf->MultiCell(12, 5, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(50 , 5, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(8, 5, 'Sex :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, $student->sex,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Age :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6 , 5, $yearsOfAge,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Birthday:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(28 , 5, date('F d, Y',strtotime($bdate)),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$next = $settings->school_year+1;
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(12, 5, 'Grade:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15 , 5, $student->level,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, 'Strand:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, $student->section,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'School Year:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, $settings->school_year.' - '.$next,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, 'Curriculum:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'K - 12','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(12, 5, 'LRN:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, $student->lrn ,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(140, 5, 'REPORT ON LEARNING PROGRESS AND ACHIEVEMENT',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(8);
$pdf->MultiCell(40, 5, 'First Semester',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX(8);
$pdf->SetFillColor(200, 220, 255);
$pdf->MultiCell(90, 10.5, 'SUBJECTS',1, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30 , 5, 'Quarter','LTR', 'C', 1, 0, '', '', true, 0, false, true,5, 'T');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(15 , 10.5, 'Semester Final Grade',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetXY(98, 52.5);
$pdf->MultiCell(15, 5, '1','LTR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(15, 5, '2','LTR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
$coreSubs1 = Modules::run('subjectmanagement/getSHSubjects', $student->grade_id, 1, segment_6, 1);  
$appliedSubs1 = Modules::run('subjectmanagement/getSHSubjects', $student->grade_id, 1, segment_6); 
//loop through the subjects
$i=0;
$m = 0;
$mp = 0;
$s1 = 0;
$s2 = 0;
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(204, 204, 204);
    $pdf->SetX(8);
    $pdf->MultiCell(90, 5, 'Core Subjects','L', 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '','T', 'C',1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','T', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','TR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();       
    $pdf->SetFont('helvetica', 'N', 8);    
foreach($coreSubs1 as $sub1){
    $s1++;
    $singleSub1 = Modules::run('academic/getSpecificSubjects', $sub1->sh_sub_id);
    $finalGrade1 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub1->subject_id, 1, segment_4);  
    $finalGrade2 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub1->subject_id, 2, segment_4);  
    $pdf->SetX(8);
    $pdf->MultiCell(90, 5, $singleSub1->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade1->row()->final_rating!=0?$finalGrade1->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade2->row()->final_rating!=0?$finalGrade2->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade2->row()->final_rating!=0?(round(($finalGrade1->row()->final_rating+$finalGrade2->row()->final_rating)/2, 2)):""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();
    $cs1Total += ($finalGrade1->row()->final_rating+$finalGrade2->row()->final_rating)/2;
}
    $pdf->SetX(8);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(90, 5, 'Applied and Specialized Subjects ','L', 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '','T', 'C',1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','T', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','TR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);   
foreach($appliedSubs1 as $asub1){
    $s1++;
    $asingleSub1 = Modules::run('academic/getSpecificSubjects', $asub1->sh_sub_id);
    $finalGrade3 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $asingleSub1->subject_id, 1, segment_4);  
    $finalGrade4 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $asingleSub1->subject_id, 2, segment_4);  
    $pdf->SetX(8);
    $pdf->MultiCell(90, 5, $asingleSub1->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade3->row()->final_rating!=0?$finalGrade3->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade4->row()->final_rating!=0?$finalGrade4->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade4->row()->final_rating!=0?(round(($finalGrade3->row()->final_rating+$finalGrade4->row()->final_rating)/2, 2)):""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();
    $aps1Total += (($finalGrade3->row()->final_rating+$finalGrade4->row()->final_rating)/2);
}   
    $generalAverage1 = round(($cs1Total + $aps1Total)/$s1,3);
    $pdf->SetX(8);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(55, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '',0, 'C',0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(50, 5, 'General Average for the Semester',0, 'C',0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, $generalAverage1,1, 'C',0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();  
    

$coreSubs2 = Modules::run('subjectmanagement/getSHSubjects', $student->grade_id, 2, segment_6, 1);  
$appliedSubs2 = Modules::run('subjectmanagement/getSHSubjects', $student->grade_id, 2, segment_6); 

    $pdf->Ln(5);
    $pdf->SetX(8);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(40, 5, 'Second Semester',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetX(8);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->MultiCell(90, 10.5, 'SUBJECTS',1, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30 , 5, 'Quarter','LTR', 'C', 1, 0, '', '', true, 0, false, true,5, 'T');
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->MultiCell(15 , 10.5, 'Semester Final Grade',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->SetXY(98, 170.5);
    $pdf->MultiCell(15, 5, '3','LTR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '4','LTR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
  
    
    $pdf->SetFillColor(204, 204, 204);
    $pdf->SetX(8);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(90, 5, 'Core Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '','TB', 'C',1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','TB', 'C',1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','TRB', 'C',1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);
    
    foreach($coreSubs2 as $sub2){
        $s2++;
        $singleSub2 = Modules::run('academic/getSpecificSubjects', $sub2->sh_sub_id);
        $finalGrade3 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub2->subject_id, 3, segment_4);  
        $finalGrade4 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub2->subject_id, 4, segment_4);  
        $pdf->SetX(8);
        $pdf->MultiCell(90, 5, $singleSub2->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($finalGrade3->row()->final_rating!=0?$finalGrade3->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(15, 5, ($finalGrade4->row()->final_rating!=0?$finalGrade4->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(15, 5, ($finalGrade3->row()->final_rating!=0?(round(($finalGrade3->row()->final_rating+$finalGrade4->row()->final_rating)/2, 2)):""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->Ln();
        $cs2Total += ($finalGrade3->row()->final_rating+$finalGrade4->row()->final_rating)/2;
    }
    
    $pdf->SetX(8);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(90, 5, 'Applied and Specialized Subjects','L', 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '','T', 'C',1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','T', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, '','TR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);   
foreach($appliedSubs2 as $asub2){
    $s2++;
    $asingleSub2 = Modules::run('academic/getSpecificSubjects', $asub2->sh_sub_id);
    $finalGrade3 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $asingleSub2->subject_id, 3, segment_4);  
    $finalGrade4 = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $asingleSub2->subject_id, 4, segment_4);  
    $pdf->SetX(8);
    $pdf->MultiCell(90, 5, $asingleSub2->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade3->row()->final_rating!=0?$finalGrade3->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade4->row()->final_rating!=0?$finalGrade4->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, ($finalGrade4->row()->final_rating!=0?(round(($finalGrade3->row()->final_rating+$finalGrade4->row()->final_rating)/2, 2)):""),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();
    $aps2Total += (($finalGrade3->row()->final_rating+$finalGrade4->row()->final_rating)/2);
}
    $generalAverage2 = round(($cs2Total + $aps2Total)/$s2,3);
    $pdf->SetX(8);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(55, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '',0, 'C',0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(50, 5, 'General Average for the Semester',0, 'C',0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(15, 5, $generalAverage2,1, 'C',0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln();   
//end of Grading Sheets



//    if(!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
//       if($generalFinal!=""): 
//            Modules::run('gradingsystem/saveFinalAverage', $student->uid, round(($generalFinal/$i),3), $sy); 
//       endif;
//    endif;


//Start of right Column
$pdf->SetXY(145,3);
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(15);
$pdf->setX(150);
$pdf->MultiCell(140, 5, 'REPORTS ON LEARNERS OBSERVED VALUES',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


$pdf->setX(150);
$pdf->MultiCell(30, 10.5, 'CORE VALUES',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');  	
$pdf->MultiCell(65, 10.5, 'Behavioral Statements',1, 'C', 1, 0, '', '', true, 0, false, true, 10.5, 'M'); 
$pdf->MultiCell(48, 5, 'Quarter',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M'); 

$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetXY(245, 28.5);
$pdf->MultiCell(12, 5, '1',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '2',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '3',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '4',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();

$coreValues = Modules::run('gradingsystem/getCoreValues');

    
    foreach ($coreValues as $cv):
        $customList = Modules::run('gradingsystem/getBehaviorRate', $cv->core_id);
        $customCount = count($customList->result());
        $rowCount = $customCount * 10.5;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setX(150);
        $pdf->MultiCell(30, $rowCount, $cv->core_values,1, 'C', 0, 0, '', '', true, 0, false, true, $rowCount, 'M');
        foreach ($customList->result() as $cl):
            $firstbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 1, $sy);
            $firstBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $cl->bh_id, $firstbhg->total);
            $secondbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 2, $sy);
            $secondBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $cl->bh_id, $secondbhg->total);
            $thirdbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 3, $sy);
            $thirdBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $cl->bh_id, $thirdbhg->total);
            $fourthbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 4, $sy);
            $fourthBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $cl->bh_id, $fourthbhg->total);
            
            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->setX(180);
            $pdf->MultiCell(65, 10.5, $cl->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 10.5, 'T'); 
            $pdf->SetFont('helvetica', 'N', 10);
            $pdf->MultiCell(12, 10.5, $firstBHtrans,1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M'); 
            $pdf->MultiCell(12, 10.5, $secondBHtrans,1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M'); 
            $pdf->MultiCell(12, 10.5, $thirdBHtrans,1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M'); 
            $pdf->MultiCell(12, 10.5, ($fourthbhg->total==0?"":$fourthBHtrans),1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M'); 
            $pdf->Ln();
        endforeach;
        //$pdf->Ln();
    endforeach;

    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Ln(4);
    $pdf->SetX(170);
    $pdf->MultiCell(110, 5, 'DESCRIPTIONS:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->Ln(4);
    $pdf->SetX(170);
    $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, 'Outstanding :  90 - 100',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->MultiCell(55, 5, 'Very Satisfactory : 85 - 89',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->Ln(4);
    $pdf->SetX(170);
    $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, 'Satisfactory: 80 - 84',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->MultiCell(55, 5, 'Fairly Satisfactory :  75-79',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->Ln(4);
    $pdf->SetX(170);
    $pdf->MultiCell(25 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, 'Did Not Meet Expectations :   Below 75',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    
        
//Attendance Record    
    
$pdf->Ln(7);
$pdf->SetX(155);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(145, 5, 'ATTENDANCE REPORT',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(30, 5, '',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Jun',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Jul',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Aug',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Sept',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Oct',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Nov',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Dec',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Jan',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Feb',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Mar',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Apr',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Tot',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(30, 5, 'No. of Days in SY',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
    if(date('Y')>$sy):
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
    
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    
    $pdf->MultiCell(8, 5,$totalDaysInAMonth ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
}

$pdf->MultiCell(8, 5, $totalDays,1, 'BR', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(30, 5, 'No of Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
    if(date('Y')>$sy):
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
    
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;

            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            else:    
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            endif;
        
    if($pdays>0):
        $pdf->MultiCell(8, 5, ($pdays>$totalDaysInAMonth?$totalDaysInAMonth:$pdays),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
    else:
        $pdf->MultiCell(8, 5, 0 ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    endif; 
         
    $total_pdays += $pdays;
    
}

$pdf->MultiCell(8, 5, $total_pdays,1, 'BR', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(30, 5, 'No of Days Absent',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
    if(date('Y')>$sy):
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
    
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;

            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            else:    
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            endif;
    $adays = $totalDaysInAMonth-$pdays;
    if($pdays>0):
        $pdf->MultiCell(8, 5, ($adays<0?0:$adays),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
    else:
        $pdf->MultiCell(8, 5, 0 ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    endif; 
         
    $total_adays += ($totalDaysInAMonth-$pdays);
    
}

$pdf->MultiCell(8, 5, $total_adays,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');



$pdf->Ln(15);
$pdf->SetX(127);
$pdf->MultiCell(30 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln();
$pdf->SetX(127);
$pdf->MultiCell(30 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, 'Adviser',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');