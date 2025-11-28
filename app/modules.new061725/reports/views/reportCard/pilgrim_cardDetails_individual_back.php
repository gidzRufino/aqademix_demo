<?php

$coreSubsFSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 1, $student->strnd_id, 1);  
$appliedSubsFSem  = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 1, $student->strnd_id); 

$coreSubsSSem = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 2, $student->strnd_id, 1);  
$appliedSubsSSem  = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, 2, $student->strnd_id); 

$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('helvetica', 'B', 8);


//left column

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetY(8);
$pdf->MultiCell(148, 0, 'REPORT ON LEARNER\'S PROGRESS AND ACHIEVEMENT',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
// THIS IS THE LEFT SIDE
$pdf->SetX(10);
$pdf->MultiCell(75, 11, 'First Semester',0, 'L', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->Ln(8);

$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(10);
$pdf->MultiCell(75, 11, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(30, 5, 'Quarter',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(25, 11,'Semester Final Grade',1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->Ln();
$pdf->SetXY(85,27.5);
$pdf->MultiCell(15, 5, '1','LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '2','LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();

$pdf->SetFillColor(150, 166, 234);
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'b', 8);
$pdf->MultiCell(130, 5, 'Core Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'T');
$mp = 0;
$fsSub = 0;


foreach($coreSubsFSem as $sub):
        $fsSub++;
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
        $firstGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 1, $sy); 
        $secondGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 2, $sy); 
        $pdf->Ln();
        $pdf->SetX(10);
        if($sub->is_core):
            $mp++;
            $pdf->SetFont('helvetica', 'N', 7);
            $pdf->MultiCell(75, 5,'   '.$sub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        if($sub->is_core):
            if($firstGrade->row()->final_rating!=""):
                
                $pdf->MultiCell(15, 5, ($firstGrade->row()?$firstGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, ($secondGrade->row()?$secondGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', 'B', 7);
                $pdf->MultiCell(25, 5, ($secondGrade->row()?round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,0):''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $coreTotal += ($secondGrade->row()?round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2):0);
            else:
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            endif; 
        endif; 

endforeach;



$pdf->Ln();
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'b', 8);
$pdf->MultiCell(130, 5, 'Applied and Specialized Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');  
   
$addRowValue = 0;
foreach($appliedSubsFSem as $sub):
    $fsSub++;
    $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
    $firstGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 1, $sy); 
    $secondGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 2, $sy); 
    $pdf->Ln();
    $pdf->SetX(10);
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->MultiCell(75, 5,'   '.$sub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $mp++;
    if($firstGrade->row()->final_rating!=""):
        $pdf->MultiCell(15, 5, ($firstGrade->row()?$firstGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($secondGrade->row()?$secondGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, ($secondGrade->row()?round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,0):''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $appliedTotal += ($secondGrade->row()?round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2):0);
    else:
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    endif; 


endforeach; 
    
$specialClass = Modules::run('sf10/checkSpecialClass', $student->st_id, $sy, '1');
if($specialClass->row()):
    foreach($specialClass->result() as $spSub):
        $fsSub++;
        $singleSub = Modules::run('academic/getSpecificSubjects', $spSub->subject_id);
        $firstGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 1, $sy); 
        $secondGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 2, $sy); 
        $pdf->Ln();
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'N', 7);
        $pdf->MultiCell(75, 5,'   '.$singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $mp++;
        if($firstGrade->row()->final_rating!=""):
            $pdf->MultiCell(15, 5, ($firstGrade->row()?$firstGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, ($secondGrade->row()?$secondGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->MultiCell(25, 5, ($secondGrade->row()?round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,0):''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $appliedTotal += ($secondGrade->row()?round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2):0);
        else:
            $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        endif; 
        $addRowValue += 4;
    endforeach;
    
endif;

$pdf->Ln();
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 5, 'General Average for the Semester', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '', 0, 'L', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, (($appliedTotal+$coreTotal)!=0?round(($appliedTotal+$coreTotal)/$fsSub,0):''), 1, 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');


$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(3);
$pdf->SetX(10);
$pdf->MultiCell(75, 11, 'Second Semester',0, 'L', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->Ln(8);

$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(10);
$pdf->MultiCell(75, 11, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(30, 5, 'Quarter',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(25, 11,'Semester Final Grade',1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->Ln();
$pdf->SetXY(85,102+$addRowValue + $fsSub);
$pdf->MultiCell(15, 5, '1','LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '2','LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();

$pdf->SetFillColor(150, 166, 234);
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'b', 8);
$pdf->MultiCell(130, 5, 'Core Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'T');
$mp = 0;
$m = 0;
$ssSub = 0;

foreach($coreSubsSSem as $sub):
        $ssSub++;
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
        $thirdGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 3, $sy); 
        $fourthGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 4, $sy); 
        $pdf->Ln();
        $pdf->SetX(10);
        if($sub->is_core):
            $mp++;
            $pdf->SetFont('helvetica', 'N', 7);
            $pdf->MultiCell(75, 5,'   '.$sub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        if($sub->is_core):
            if($thirdGrade->row()):
                $pdf->MultiCell(15, 5, ($thirdGrade->row()?$thirdGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, ($fourthGrade->row()?$fourthGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', 'B', 7);
                $pdf->MultiCell(25, 5, ($fourthGrade->row()?round(($thirdGrade->row()->final_rating+$fourthGrade->row()->final_rating)/2,0):''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $coreTotal2 += ($fourthGrade->row()?round(($thirdGrade->row()->final_rating+$fourthGrade->row()->final_rating)/2,0):0);
            else:
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            endif; 
        endif; 

endforeach;

$specialClass2 = Modules::run('sf10/checkSpecialClass', $student->st_id,$sy, '2');
if($specialClass2->row()):
    foreach($specialClass2->result() as $spSub):
        $ssSub++;
        $singleSub = Modules::run('academic/getSpecificSubjects', $spSub->subject_id);
        $thirdGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 3, $sy); 
        $fourthGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 4, $sy); 
        $pdf->Ln();
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'N', 7);
        $pdf->MultiCell(75, 5,'   '.$singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $mp++;
        if($thirdGrade->row()->final_rating!=""):
            $pdf->MultiCell(15, 5, ($thirdGrade->row()?$thirdGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, ($fourthGrade->row()?$fourthGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->MultiCell(25, 5, ($fourthGrade->row()?round(($thirdGrade->row()->final_rating+$fourthGrade->row()->final_rating)/2,0):''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $appliedTotal2 += ($fourthGrade->row()?round(($thirdGrade->row()->final_rating+$fourthGrade->row()->final_rating)/2,2):0);
        else:
            $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        endif; 
        $addRowValue += 4;
    endforeach;
    
endif;



$pdf->Ln();
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'b', 8);
$pdf->MultiCell(130, 5, 'Applied and Specialized Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');  
   

foreach($appliedSubsSSem as $sub):
    $ssSub++;
    $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
        $thirdGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 3, $sy); 
        $fourthGrade = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $singleSub->subject_id, 4, $sy);; 
    $pdf->Ln();
    $pdf->SetX(10);
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->MultiCell(75, 5,'   '.$sub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $mp++;
    if($thirdGrade->row()):
        $pdf->MultiCell(15, 5, ($thirdGrade->row()?$thirdGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($fourthGrade->row()?$fourthGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, ($fourthGrade->row()?round(($thirdGrade->row()->final_rating+$fourthGrade->row()->final_rating)/2,0):''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $appliedTotal2 += ($fourthGrade->row()?round(($thirdGrade->row()->final_rating+$fourthGrade->row()->final_rating)/2,0):0);
    else:
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    endif; 


endforeach; 

$pdf->Ln();
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 5, 'General Average for the Semester', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '', 0, 'L', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, (($appliedTotal2+$coreTotal2)!=0?round(($appliedTotal2+$coreTotal2)/$ssSub,0):''), 1, 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


//Start of right Column
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetXY(145,8);
$pdf->MultiCell(0, 10, 'REPORTS ON LEARNER\'S OBSERVED VALUES',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 10.5, 'Core Values',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 10.5, 'Behavior Statements',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(44, 5, 'Quarter','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetXY(245,28);
    $pdf->MultiCell(11, 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(11, 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(11, 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(11, 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    
    $pdf->SetFont('helvetica', 'N', 8);
    
function getRating($rate)
{
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
    $coreValues = Modules::run('gradingsystem/getCoreValues');
    
    foreach ($coreValues as $cv):
        
        $customList = Modules::run('gradingsystem/getBehaviorRate', $cv->core_id);
        $customCount = count($customList->result());
        $rowCount = $customCount * 13;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setX(155);
        $pdf->MultiCell(40, $rowCount, $cv->core_values,'RLB', 'C', 0, 0, '', '', true, 0, false, true, $rowCount, 'M');
        foreach ($customList->result() as $cl):
            $firstbhg = Modules::run('gradingsystem/getBHRating', $student->st_id,1, $sy, $cl->bh_id); 
            $secondbhg = Modules::run('gradingsystem/getBHRating', $student->st_id,2, $sy, $cl->bh_id); 
            $thirdbhg = Modules::run('gradingsystem/getBHRating', $student->st_id,3, $sy, $cl->bh_id); 
            $fourthbhg = Modules::run('gradingsystem/getBHRating', $student->st_id,4, $sy, $cl->bh_id); 
            
            
            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->setX(195);
            $pdf->MultiCell(50, 13, $cl->bh_name,'RB', 'L', 0, 0, '', '', true, 0, false, true, 13, 'T'); 
            $pdf->SetFont('helvetica', 'N', 10);
            $pdf->MultiCell(11, 13, ($firstbhg->row()?$firstbhg->row()->transmutation:''),1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M'); 
            $pdf->MultiCell(11, 13, ($secondbhg->row()?$secondbhg->row()->transmutation:''),1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M'); 
            $pdf->MultiCell(11, 13, ($thirdbhg->row()?$thirdbhg->row()->transmutation:''),1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M'); 
            $pdf->MultiCell(11, 13, ($fourthbhg->row()?$fourthbhg->row()->transmutation:''),1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M'); 
            
            $pdf->Ln();
        endforeach;
        
    endforeach;

    $pdf->SetX(155);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(0, 5, 'Observed Values',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4.5);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'Marking',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Non-Numerical Rating',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'AO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Always Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'SO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Sometimes Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'RO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Rarely Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'NO',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Not Observed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(10);
    $pdf->SetX(155);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(0, 5, 'Learner Progress and Achievement',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4.5);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'Descriptors',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Grading Scale',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Remarks',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'Outstanding',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '90-100',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'Very Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '85-89',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '80-84',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'Fairly Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '75-89',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Passed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(155);
    $pdf->MultiCell(40, 5, 'Did not Meet Expectations',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Below 75',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, 'Failed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    
$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES.'/pilgrim.jpg';
$pdf->Image($image_file, 65,25, 160, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    
    