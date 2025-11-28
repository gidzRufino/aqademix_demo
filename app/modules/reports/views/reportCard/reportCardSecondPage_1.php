<?php

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


$pdf->Line(148, 5, 148, 1, array('color' => 'black'));

$pdf->SetFont('helvetica', 'B', 8);
if($student->grade_id==18):
    $pdf->SetXY(59.9,100);
else:
    $pdf->SetXY(59.9,115.9);
endif;

$pdf->StartTransform();
$pdf->Rotate(90);
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Hunyo',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Hulyo',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Agosto',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Setyembre',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Octubre',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Nobyembre',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Disyembre',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Enero',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Pebrero',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Marso',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 5, 'Abril',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(18, 7, 'Kabuuan',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

$pdf->StopTransform();


//left column

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetY(8);
$pdf->MultiCell(148, 0, 'ULAT TUNGKOL SA PAG-UNLAD NG MARKA',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(15);
$pdf->SetX(15);
$pdf->MultiCell(40, 10.5, 'Larangan ng Pag-aaral',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(48 , 5, 'Markahan','LTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12 , 10.5, 'Huling Marka',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(12 , 10.5, 'Yunit',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(12 , 10.5, 'Pasya',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetXY(55, 28);
$pdf->MultiCell(12, 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();

$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
$subject = explode(',', $subject_ids->subject_id);
$i=0;
foreach($subject as $s){
    $i++;
    $singleSub = Modules::run('academic/getSpecificSubjects', $s);
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, $singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    if($student->grade_id!=18):
	$fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, $term, $sy);
        if(getGrade(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, $term, $sy))==""):
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        else:
           $units = $singleSub->unit_a;
           $totalUnits += $units;
           $partialGrade = ($fg->row()->final_rating * $units);

           $pdf->MultiCell(12, 5, getGrade(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, 1, $sy)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
           $pdf->MultiCell(12, 5, getGrade(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, 2, $sy)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
           $pdf->MultiCell(12, 5, getGrade(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, 3, $sy)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
           $pdf->MultiCell(12, 5, getGrade(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, 4, $sy)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
        endif;
        $final += $partialGrade;
    else:
        $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, $term, $sy);
        if($fg->row()->final_rating!=""):
            if($s!=17):
                $pdf->MultiCell(12, 5, $fg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            else:
                if($fg->row()->final_rating!=0):
                    $pdf->MultiCell(12, 6, 'Passed',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                endif;
            endif;
                $final += $fg->row()->final_rating;
                
        else:
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        endif;
    endif;
    
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
     if($student->grade_id==18):
         $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
         $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
         $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
     endif;
    
    $pdf->Ln();
}
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, 'General Average',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    if($student->grade_id==18):
    	$pdf->MultiCell(12, 5, $final/($i-1),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        $final = $final/($totalUnits);
        $plg = Modules::run('gradingsystem/getLetterGrade', $final);
        foreach($plg->result() as $plg){
		if( $final >= $plg->from_grade && $final <= $plg->to_grade){
		    
	      
		        $grade = $plg->letter_grade;
		   
		    if($grade!=""):
		        $grade = $grade;
		    else:
		        $grade = "";
		    endif;
		}
	    }
        $pdf->MultiCell(12, 5, $grade,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    endif;
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    if($student->grade_id!=18):
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
        $pdf->Ln(10);
   else:
        $pdf->Ln(40);    
   endif;
//list of subjects




$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(148, 0, 'ULAT NG PAGPASOK',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(8);
$pdf->SetX(20);
$pdf->MultiCell(40, 18, '',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(20);
$pdf->MultiCell(40, 10, 'Bilang ng araw na may pasok',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
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
    
    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), date('Y'), 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), date('Y'), 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m);
    $holiday = Modules::run('calendar/holidayExist', $m);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    $pdf->MultiCell(5.5, 10,$totalDaysInAMonth ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}

$pdf->MultiCell(7, 10, $totalDays,1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(20);
$pdf->MultiCell(40, 10, 'Bilang ng araw na pumasok',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    else:
        $schoolYear = $sy;
    endif;
    
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), date('Y'), 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), date('Y'), 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m);
    $holiday = Modules::run('calendar/holidayExist', $m);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    
     for($y=$firstDay;$y<=$lastDay;$y++){
         $day = date('D', strtotime(date('Y').'-'.$m.'-'.$y));

        if($day=='Sat'||$day=='Sun')
        {

        }else{
            if($this->session->userdata('attend_auto')):
                $ifPresent = Modules::run('attendance/ifPresent',$student->st_id, $y, $m);
            else:    
                $ifPresent = Modules::run('attendance/ifPresent',$student->uid, $y, $m);
            endif;
            
            if($ifPresent):
                $pdays += 1;
            endif;
        }
     }
     if($sy==$schoolYear):
         if(abs("$m")< date('n')):
            $pdf->MultiCell(5.5, 10, $pdays,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
         else:
             $pdf->MultiCell(5.5, 10, '',1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
         endif;
      
     else:   
         $pdf->MultiCell(5.5, 10, '',1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
     endif;
     
    $pdays = 0;
}


$pdf->MultiCell(7, 10, '',1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(20);
$pdf->MultiCell(40, 10, 'Bilang ng araw na pumasok na huli',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$tardy = 0;
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    else:
        $schoolYear = $sy;
    endif;
    
     for($y=$firstDay;$y<=$lastDay;$y++){
         $day = date('D', strtotime(date('Y').'-'.$m.'-'.$y));

        if($day=='Sat'||$day=='Sun')
        {

        }else{
            if($this->session->userdata('attend_auto')):
                $ifPresent = Modules::run('attendance/ifPresent',$student->st_id, $y, $m);
            else:    
                $ifPresent = Modules::run('attendance/ifPresent',$student->uid, $y, $m);
            endif;
            
            if($ifPresent):
                if($y<10):
                    $day = "0".$y;
                else:
                    $day = $y;
                endif;
                if($this->session->userdata('attend_auto')):
                    $remarks = Modules::run('attendance/getAttendanceRemark', $student->st_id, $m.'/'.$day.'/'.date('Y'));
                else:
                    $remarks = Modules::run('attendance/getAttendanceRemark', $student->uid, $m.'/'.$day.'/'.date('Y'));
                endif;
                if($remarks->row()->remarks==1 ):
                    $tardy = $tardy + $remarks->num_rows();
                endif;
                
            endif;
        }
     }
     if($sy==$schoolYear):
         if(abs("$m")< date('n')):
            $pdf->MultiCell(5.5, 10,$tardy,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
         else:
             $pdf->MultiCell(5.5, 10, '',1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
         endif;
      
     else:   
         $pdf->MultiCell(5.5, 10, '',1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
     endif;
    $tardy = 0; 
    $pdays = 0;
}
$pdf->MultiCell(7, 10, '',1, 'BR', 0, 0, '', '', true, 0, false, true, 10, 'M');

function getRating($behaviorRating)
{
    $rate = $behaviorRating->row()->rate;
    switch ($rate)
    {
        case 1:
            $star = '*';
        break;    
        case 2:
            $star = '**';
        break;    
        case 3:
            $star = '***';
        break; 
     
        default :
            $star = '';
        break;
    }
    return $star;
}

   
//Start of right Column
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetXY(145,8);
$pdf->MultiCell(0, 10, 'PAG-UNLAD SA TAGLAY NA MGA
PAGPAPAHALAGA AT SALOOBIN',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->SetFont('helvetica', 'N',8);
$pdf->Ln(15);
$pdf->setX(160);
$pdf->MultiCell(130, 10, 'Panuto: Lagayan ng Talong (3) star (***) kung lubhang Kasiya-siya ang ipinamalas, dalawang (2) star(**) kung kasiya-siya, at isang (1) star(*) kung dapat pang linangin sa mag-aaral.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(15);
$pdf->setX(160);
$pdf->MultiCell(90, 10.5, 'Mga kinakailangang namasid na pagpapahalaga at saloobin',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40 , 5.5, 'Markahan','LTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->SetXY(250, 43);
$pdf->MultiCell(10 , 5, '1',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10 , 5, '2',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10 , 5, '3',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10 , 5, '4',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 7);
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                        Nagpamalas ng Kasiya-siyang gawi tungo sa pagpananatili ng kaangkupang pisikal at mental.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 1)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 1)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 1)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 1)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '               Nagpamalas ng pagkamalikhain sa pagsasagawa ng ibat-ibang gawain.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                      Nagpakita ng paggalang sa pagkakaiba-iba ng mga paniniwala at palagay ng tao.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 3)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 3)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 3)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 3)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                           Nagpakita ng katapatan sa lahat ng pagkakataon.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 4)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 4)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 4)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 4)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');


$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                   Nagpamalas ng kusang-loob na malinang ang angkop na pagkilos sa pagsasagawa ng mga gawain.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 5)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 5)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 5)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 5)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                      Nagpakita ng pag-galang sa pagkakaiba ng relihiyon, tulad ng mga lugar ng pagsamba at mga simbolong banal.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,$term, $sy, 6)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, '',1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, '',1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, '',1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                                            Nagpapakita ng paggalang sa pagkakapantay-pantay ng lahat maging anuman ang edad, kasarian, lahi, wika, relihiyon, paniniwalang political, katayuang panlipunan at kapansanan.','LTR', 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 7)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 7)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 7)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 7)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                              Nagpamalas ng kaaya-ayang pakikitungo sa kapwa',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 8)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 8)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 8)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 8)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');


$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                                      Pinangangalagaan ang kapaligiran',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 9)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 9)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 9)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 9)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                                                     Ginagamit ang mga resorses sa ekonomical na paraan',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 10)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 10)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 10)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 10)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                                                     Nagpapakita ng pagmamalaki sa mga katutubo at kontemporaryong sining at kultura ng Pilipinas',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 11)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 11)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 11)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 11)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                                     Nagpakita ng pag-unawa sa mga pangunahing kalayaan at mga katumbas na pananagutan',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 12)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 12)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 12)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 12)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                                    Nagsagawa ng sariling responsibilidad ng may dedikasyon',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 13)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 13)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 13)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 13)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(160);
$pdf->MultiCell(90, 10, '                                                Nagpamalas ng pakikiisa sa sariling bansa sa kabila ng pagkakaiba-iba ng paniniwalang political at cultural, wika at relihiyon.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, 14)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, 14)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, 14)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(10, 10, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, 14)),1, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');

$pdf->SetFont('helvetica', 'N', 7);
//bold letters of the above
$pdf->setXY(160, 46.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Kaangkupang Pisikal - ',0,0,'L');
$pdf->setXY(160, 56.5);
$pdf->Cell(0,10,'Sining -',0,0,'L');
$pdf->setXY(160, 66.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Tolerance - ',0,0,'L');
$pdf->setXY(160, 77.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Katapatan / Integridad - ',0,0,'L');
$pdf->setXY(160, 86.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Disiplina sa Sarili - ',0,0,'L');
$pdf->setXY(160, 96.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Religious Tolerance - ',0,0,'L');
$pdf->setXY(160, 105.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Paggalang sa Karapatang Pantao - ',0,0,'L');
$pdf->setXY(160, 117.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Mapayapang Pakikilahok - ',0,0,'L');
$pdf->setXY(160, 128);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Pangangalaga sa kapaligiran - ',0,0,'L');
$pdf->setXY(160, 136.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Tamang Paggamit ng mga Resorses - ',0,0,'L');
$pdf->setXY(160, 146.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Pagpapahalaga sa Yamang Kultural - ',0,0,'L');
$pdf->setXY(160, 156.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Kalayaan at Pananagutan - ',0,0,'L');
$pdf->setXY(160, 167.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Mapanagutang Pamumuno - ',0,0,'L');
$pdf->setXY(160, 176.5);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0,10,'Pambansang Pagkakaisa - ',0,0,'L');
?>
