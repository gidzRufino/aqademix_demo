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

function getFinalGrade($grade)
{
    $plg = Modules::run('gradingsystem/getLetterGrade', $grade);
    foreach($plg->result() as $plg){
        if( $grade >= $plg->from_grade && $grade <= $plg->to_grade){
            
      
                $ltrGrade = $plg->letter_grade;
           
            if($grade!="" || $grade!=0 || $grade > 60):
                $ltrGrade = $ltrGrade;
            else:
                $ltrGrade ='';
            endif;
        }
    }
    
    return $ltrGrade;
}


$pdf->Line(139.5, 5, 139.5, 1, array('color' => 'black'));

$pdf->SetFont('helvetica', 'B', 8);

//left column

$pdf->SetFont('helvetica', 'B', 11);
$pdf->SetY(3);
$pdf->MultiCell(140, 10, 'ACADEMIC',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(8);
$pdf->SetX(5);
$pdf->MultiCell(40, 5, 'SUBJECT','BTL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '1ST','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '2ND','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '3RD','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '4TH','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(18, 5, 'FINAL','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(18, 5, 'REMARKS','BTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->SetX(55);
$pdf->SetFont('helvetica', 'N', 8);
$subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
//$subject = explode(',', $subject_ids->subject_id);
$i=0;
foreach($subject as $s){
    $i++;
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $grade = json_decode(Modules::run('gradingsystem/getGradeForCard', $student->uid, $s->sub_id, $sy));
    $first = transmuteGrade($grade->first);
    $second = transmuteGrade($grade->second);
    $third = transmuteGrade($grade->third);
    $fourth = transmuteGrade($grade->fourth);
    
    
    $pdf->SetX(5);
    $pdf->MultiCell(40, 5, $singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    if($student->grade_id!=18):
	$fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
        if($grade->first==""):
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
            $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        else:
          $units = $singleSub->unit_a;
          // $totalUnits += $units;
           $partialGrade = ($fg->row()->final_rating);

           $pdf->MultiCell(12, 5, $first,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
           $pdf->MultiCell(12, 5, $second,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
           $pdf->MultiCell(12, 5, $third,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
           $pdf->MultiCell(12, 5, $fourth,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T'); 
        endif;
        
        $firstFinal += transmuteGrade($first);
        $secondFinal += transmuteGrade($second) ;
        $thirdFinal += transmuteGrade($third);
        $fourthFinal += transmuteGrade($fourth);

    else:
        $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
        if($grade->first!=""):
            if($s->sub_id!=17):
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
    $finalAverage = ($first+$second+$third+$fourth)/4;
    $generalFinal += $finalAverage;
    if($fourth!=0):
        $pdf->MultiCell(18, 5, number_format(round($finalAverage, 3),2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        $pdf->MultiCell(18, 5,'',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');    
    endif;
    
    if($fourth!=0):
            if($finalAverage > 75):
                $pdf->MultiCell(18, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
            else:
                 $pdf->SetTextColor(255, 0, 0);
                 $pdf->MultiCell(18, 5, 'Failed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                 $pdf->SetTextColor(000, 0, 0);

            endif;
        else:
            $pdf->MultiCell(18 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
     if($student->grade_id==18):
         $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
         $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
         $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
     endif;
    
     Modules::run('gradingsystem/saveGeneralAverage', $student->section_id, $student->uid, $s->sub_id, $sy, $finalAverage);
    $pdf->Ln();
} //end of Grades


    $pdf->SetX(5);
    $pdf->MultiCell(40, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M'); 
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(18 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->MultiCell(40, 5, 'General Average',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
    if($student->grade_id==18):
    	$pdf->MultiCell(12, 5, $final/($i-1),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        if(transmuteGrade($firstFinal/$i)!=""):
            $pdf->MultiCell(12, 5, number_format($firstFinal/$i, 2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        else:
            $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        if(transmuteGrade($secondFinal/$i)!=""):
            $pdf->MultiCell(12, 5, number_format($secondFinal/$i, 2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        else:
            $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        if(transmuteGrade($thirdFinal/$i)!=""):
            $pdf->MultiCell(12, 5, number_format($thirdFinal/$i, 2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        else:
            $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        if(transmuteGrade($fourthFinal/$i)!=""):
            $pdf->MultiCell(12, 5, number_format($fourthFinal/$i, 2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        else:
            $pdf->MultiCell(12 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
            
              
        //$pdf->MultiCell(12, 5, $grade,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    endif;
    //final
    
    $cc_first = Modules::run('gradingsystem/co_curricular/getCoCurricular', $student->uid, 1);
    $cc_second = Modules::run('gradingsystem/co_curricular/getCoCurricular', $student->uid, 2);
    $cc_third = Modules::run('gradingsystem/co_curricular/getCoCurricular', $student->uid, 3);
    $cc_fourth = Modules::run('gradingsystem/co_curricular/getCoCurricular', $student->uid, 4);
    $ccFinal = ($cc_first->rate+$cc_second->rate+$cc_third->rate+$cc_fourth->rate)/4;
    
    switch ($student->grade_id):
        case 1:
        case 2:
        case 3:
            $generalFinals = $generalFinal/$i;
        break;    
        default :
            //$generalFinals = (($generalFinal/$i)*.7)+($ccFinal*.3);
            $generalFinals = $generalFinal/$i;
        break;
    endswitch;
     
     if($fourth!=0):
        $pdf->MultiCell(18, 5, round($generalFinals,2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        $pdf->MultiCell(18, 5,'',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');    
    endif;
    if($fourth!=0):
            if($generalFinal > 75):
                $pdf->MultiCell(18, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
            else:
                 $pdf->SetTextColor(255, 0, 0);
                 $pdf->MultiCell(18, 5, 'Failed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                 $pdf->SetTextColor(000, 0, 0);

            endif;
        else:
            $pdf->MultiCell(18 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
    
     if(!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
       Modules::run('gradingsystem/saveFinalAverage', $student->uid, $generalFinals, $sy); 
    endif;
    
    
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->MultiCell(140, 10, 'CO-CURRICULAR INVOLVEMENT',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Ln(6);
    $pdf->SetX(5);
    $pdf->MultiCell(100, 5, 'ACTIVITIES','BTL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, 'RATING','BTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->MultiCell(20, 10, 'FIRST',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(85, 10, 'Wagmuna(True Love Project), True Blue,SSC Campaign/ Election, Happiness Happens Leader\'sTeam Building, LEAD Camp, Taste & See ',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->SetFont('helvetica', 'B', 8);if($cc_first->rate!=0):
        $pdf->MultiCell(20, 10, getFinalGrade($cc_first->rate),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    else:
        $pdf->MultiCell(20, 10, '',1, 'BTR', 0, 0, '', '', true, 0, false, true, 7, 'T');
    endif;
    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(20, 7, 'SECOND',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'T');
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(85, 7, 'Rainbow Day,Pusong Pinoy,School Musical, Academy Days, Science Fair, BGB Day, World Teacher\'s Day, Music Recital, YNP','T', 'L', 0, 0, '', '', true, 0, false, true, 7, 'T');
    $pdf->SetFont('helvetica', 'B', 8);
    if($cc_first->rate!=0):
        $pdf->MultiCell(20, 7, getFinalGrade($cc_second->rate),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'T');
    else:
        $pdf->MultiCell(20, 7, '',1, 'BTR', 0, 0, '', '', true, 0, false, true, 7, 'T');
    endif;
    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(20, 7, 'THIRD',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'T');
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(85, 7, 'He & She Day, Challenger\'s Day Camp, Career Day, Discoverer\'s Day Camp, LCA Camp, Christmas Banquet','T', 'L', 0, 0, '', '', true, 0, false, true, 7, 'T');
    $pdf->SetFont('helvetica', 'B', 8);
    if($cc_first->rate!=0):
        $pdf->MultiCell(20, 7, getFinalGrade($cc_third->rate),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'T');
    else:
        $pdf->MultiCell(20, 7, '',1, 'BTR', 0, 0, '', '', true, 0, false, true, 7, 'T');
    endif;
    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(20, 7, 'FOURTH',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'T');
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(85, 7, 'Bible Week, BGB National Camp, School Fieldtrip, Graduating class Fieldtrip, Wagmuna Outreach, Teacher\'s Day, Luau(Family Day/BOok Fair), Music Recital, Farewell Dinner, Tribute to Graduates, BGB Awarding, Behavioral Awarding, Graduation/Recognition','BT', 'L', 0, 0, '', '', true, 0, false, true, 7, 'T');
    $pdf->SetFont('helvetica', 'B', 8);
    if($cc_first->rate!=0):
        $pdf->MultiCell(20, 7, getFinalGrade($cc_fourth->rate),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'T');
    else:
        $pdf->MultiCell(20, 7, '',1, 'BTR', 0, 0, '', '', true, 0, false, true, 7, 'T');
    endif;
    $pdf->Ln(12);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->MultiCell(140, 10, 'ATTENDANCE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Ln(6);
    $pdf->SetX(5);

    $pdf->MultiCell(30, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Jun',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Jul',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Aug',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Sep',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Oct',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Nov',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Dec',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Jan',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Feb',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5, 'Mar',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, 'Total',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX(5);
    $pdf->MultiCell(30, 5, 'Days of School',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $x = 5;
    for($d=1;$d<=10;$d++){
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
        if($m<6 && date('Y')>$sy):
            $year = date('Y');
        else:
            $year = $sy;
        endif;

        $month = date("F", mktime(0, 0, 0, $m, 10));
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
        $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
        $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
        $holiday = Modules::run('calendar/holidayExist', $m, $year);
        $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
        $totalDays += $totalDaysInAMonth;
        $pdf->MultiCell(8, 5,$totalDaysInAMonth ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    }

    $pdf->MultiCell(15, 5, $totalDays,'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->MultiCell(30, 5, 'Days Present',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    for($d=1;$d<=10;$d++){
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
        
 

        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
        $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
        $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
        $holiday = Modules::run('calendar/holidayExist', $m, $year);
        $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
        $totalDays += $totalDaysInAMonth;

         for($y=$firstDay;$y<=$lastDay;$y++){ 
             $day = date('D', strtotime($schoolYear.'-'.$m.'-'.$y));

            if($day=='Sat'||$day=='Sun')
            {

            }else{
                if($this->session->userdata('attend_auto')):
                    $ifPresent = Modules::run('attendance/ifPresent',$student->rfid, $y, $m, $schoolYear,  NULL, segment_4);
                else:    
                    $ifPresent = Modules::run('attendance/ifPresent',$student->uid, $y, $m, $schoolYear,  NULL, segment_4);
                endif;

                if($ifPresent):
                    $pdays += 1;
                    if($pdays==0):
                        $pdays=0;
                    endif;
                endif;
            }
         }
         if($pdays>$totalDaysInAMonth):
             $pdays = $totalDaysInAMonth;
         endif;

            $pdf->MultiCell(8, 5, $pdays,'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
            $presentDaysTotal +=$pdays;
        $pdays = 0;
    }
    $pdf->MultiCell(15, 5, $presentDaysTotal,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->MultiCell(30, 5, 'Times Tardy',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $tardy = 0;
    for($d=1;$d<=10;$d++){
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
                    $ifPresent = Modules::run('attendance/ifPresent',$student->rfid, $y, $m, $schoolYear, NULL, segment_4);
                else:    
                    $ifPresent = Modules::run('attendance/ifPresent',$student->uid, $y, $m, $schoolYear,  NULL, segment_4);
                endif;

                if($ifPresent):
                    if($y<10):
                        $day = "0".$y;
                    else:
                        $day = $y;
                    endif;
                    if($this->session->userdata('attend_auto')):
                        $remarks = Modules::run('attendance/getAttendanceRemark', $student->rfid, $m.'/'.$day.'/'.$schoolYear);
                    else:
                        $remarks = Modules::run('attendance/getAttendanceRemark', $student->uid, $m.'/'.$day.'/'.$schoolYear);
                    endif;
                    if($remarks->row()->remarks==1 ):
                        $tardy = $tardy + $remarks->num_rows();
                    endif;

                endif;
            }
         }
         if($sy==$schoolYear):
            if(abs("$m")> date('n')):
               $pdf->MultiCell(8, 5,$tardy,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
            else:
                $pdf->MultiCell(8, 5, $tardy,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
            endif;

        else:   
             if(abs("$m")> date('n')):
               $pdf->MultiCell(8, 5,'',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
            else:
                $pdf->MultiCell(8, 5, $tardy,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
            endif;
        endif;
       $tardy = 0;
        $pdays = 0;
    }
        $pdf->MultiCell(15, 5, '',1, 'BR', 0, 0, '', '', true, 0, false, true, 5, 'M');


        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Ln(10);
        $pdf->SetX(10);
        $pdf->MultiCell(80, 5, 'Level of Proficiency:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(50, 5, 'Legend for:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->MultiCell(3 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(43, 5, 'Beginning (B)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(30, 5, '74% and Below',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(7, 5, 'O',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(28, 5, 'Outstanding',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->MultiCell(3 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(43, 5, 'Developing (D)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(30, 5, '75% - 79%',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(7, 5, 'VS',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(28, 5, 'Very Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->MultiCell(3 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(43, 5, 'Approaching Proficiency (AP)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(30, 5, '80% - 84%',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(7, 5, 'S',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(28, 5, 'Satisfactory',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->MultiCell(3 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(43, 5, 'Proficient (P)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(30, 5, '85% - 90%',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(7, 5, 'I',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
        $pdf->MultiCell(28, 15, 'Improving but not yet satisfactory ',0, 'L', 0, 0, '', '', true, 0, false, true, 15, 'T'); 
        
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->MultiCell(3 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(43, 5, 'Advanced (A)',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->MultiCell(30, 5, '90% and above',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M'); 
        $pdf->Ln(10);
   
        
//Start of right Column
$pdf->SetFont('helvetica', 'B', 11);
$pdf->SetY(3);
$pdf->setX(145);
$pdf->MultiCell(140, 10, 'PERSONAL ATTRIBUTE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(8);
$pdf->setX(145);
$pdf->MultiCell(40, 5, 'ATTRIBUTES','LTB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12 , 5, '1ST','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12 , 5, '2ND','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12 , 5, '3RD','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12 , 5, '4TH','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12 , 5, 'FINAL  ','BT', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(30, 5, 'REMARKS','BTR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');

$bh = Modules::run('gradingsystem/getBH');


function getRating($behaviorRating)
{
    switch ($behaviorRating->row()->rate)
    {
        case 1:
            $star = 'I';
        break;    
        case 2:
            $star = 'S';
        break;    
        case 3:
            $star = 'VS';
        break; 
        case 4:
            $star = 'O';
        break; 

        default :
            $star = '';
        break;
    }
    return $star;
}

foreach($bh as $beh)
{
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->setX(145);
    $pdf->MultiCell(40, 5, $beh->bh_name,'LTB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12 , 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,1, $sy, $beh->bh_id)),'BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12 , 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,2, $sy, $beh->bh_id)),'BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12 , 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,3, $sy, $beh->bh_id)),'BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12 , 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $beh->bh_id)),'BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    if(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $beh->bh_id)!=""):
        $pdf->MultiCell(12 , 5, getRating(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $beh->bh_id)),'BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        $pdf->MultiCell(12 , 5, '','BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    endif;
    if(Modules::run('gradingsystem/getBHRating', $student->uid,4, $sy, $beh->bh_id)!=""):
        $pdf->MultiCell(30, 5, 'PASSED','BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        $pdf->MultiCell(30, 5, '','BLR', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    endif;
}
$pdf->Ln(6);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->setX(145);
$pdf->MultiCell(140, 10, "TEACHER'S REMARKS / PARENTS FEEDBACK",0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->SetFont('helvetica', 'B', 7);

$pdf->Ln(7);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "First Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(3);
$pdf->setX(145);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(10, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(120, 5, trim($firstRemarks->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Ln(4);
$pdf->setX(145);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(27, 5, "Teacher's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(5);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "Parent's Feedback",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(3);
$pdf->setX(145);
$pdf->MultiCell(130, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(4);
$pdf->setX(145);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(25, 5, "Parent's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(37, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->Ln(6);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "Second Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(3);
$pdf->setX(145);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(130, 5, trim($secondRemarks->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->setX(145);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(27, 5, "Teacher's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(5);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "Parent's Feedback",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(3);
$pdf->setX(145);
$pdf->MultiCell(130, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(4);
$pdf->setX(145);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(25, 5, "Parent's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(37, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->Ln(6.5);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "Third Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(3);
$pdf->setX(145);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(130, 5, trim($thirdRemarks->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->setX(145);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(27, 5, "Teacher's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(5);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "Parent's Feedback",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(3);
$pdf->setX(145);
$pdf->MultiCell(130, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(4);
$pdf->setX(145);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(25, 5, "Parent's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(37, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->Ln(6.5);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "Fourth Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(3);
$pdf->setX(145);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(130, 5,trim($fourthRemarks->row()->remarks),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->setX(145);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(27, 5, "Teacher's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(35, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(5);
$pdf->setX(145);
$pdf->MultiCell(140, 5, "Parent's Feedback",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->setX(145);
$pdf->Ln(2);
$pdf->setX(145);
$pdf->MultiCell(130, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(4);
$pdf->setX(145);
$pdf->MultiCell(8, 5, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(30, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(25, 5, "Parent's Signature",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(37, 5, "",'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->SetLineStyle(array('width' => .3, 'color' => array(0, 0, 0)));
$pdf->setXY(144,113);
$pdf->MultiCell(133, 25, "",1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->setX(144);
$pdf->MultiCell(133, 25, "",1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->setX(144);
$pdf->MultiCell(133, 25, "",1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->setX(144);
$pdf->MultiCell(133, 23.5, "",1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        


?>
