<?php
class MYPDF extends Pdf {
    public function Header() {
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(335,216);
$pdf->AddPage('P', $resolution);

$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_4);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);  
$students = Modules::run('registrar/getStudentForCard', segment_7,segment_6, segment_4);
$adviser = Modules::run('academic/getAdvisory', NULL,$this->session->school_year, segment_4);
$adv = strtoupper($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0, 1).'. '.$adviser->row()->lastname);
$sy = $this->session->userdata('school_year');

$sd = Modules::run('reports/getRawSchoolDays', $sy);

switch (segment_5){
     case 1:
         $term = 'first';
         $month1 = 'JUN';
         $m1 = 'June';
         $y1 = $sy;
         $month2 = 'JULY';
         $m2 = 'July';
         $y2 = $sy;
         $month3 = 'AUG';
         $m3 = 'August';
         $y3 = $sy;
         $schoolDays1 = $sd->row()->June;
         $schoolDays2 = $sd->row()->July;
         $schoolDays3 = $sd->row()->August;
     break;
     case 2:
         $term = 'second';
         $month1 = 'AUG';
         $m1 = 'August';
         $y1 = $sy;
         $schoolDays1 = $sd->row()->August;
         $month2 = 'SEPT';
         $m2 = 'September';
         $y2 = $sy;
         $schoolDays2 = $sd->row()->September;
         $month3 = 'OCT';
         $m3 = 'October';
         $y3 = $sy;
         $schoolDays3 = $sd->row()->October;
     break;
     case 3:
         $term = 'third';
         $month1 = 'NOV';
         $m1 = 'November';
         $y1 = $sy;
         $schoolDays1 = $sd->row()->November;
         $month2 = 'DEC';
         $m2 = 'December';
         $y2 = $sy;
         $schoolDays2 = $sd->row()->December;
         $month3 = 'JAN';
         $m3 = 'January';
         $y3 = $sy+1;
         $schoolDays3 = $sd->row()->January;
     break;
     case 4:
         $term = 'fourth';
         $month1 = 'JAN';
         $m1 = 'January';
         $y1 = $sy+1;
         $schoolDays1 = $sd->row()->January;
         $month2 = 'FEB';
         $m2 = 'February';
         $y2 = $sy+1;
         $schoolDays2 = $sd->row()->February;
         $month3 = 'MAR';
         $m3 = 'March';
         $y3 = $sy+1;
         $schoolDays3 = $sd->row()->March;
     break;
}

        $totalDaysInAMonth1 = $schoolDays1;
        $totalDaysInAMonth2 = $schoolDays2;
        $totalDaysInAMonth3 = $schoolDays3;
        
        $totalDays = $totalDaysInAMonth1 + $totalDaysInAMonth2 + $totalDaysInAMonth3;
        
        
$x=3;
$y=5;
$a=0;

//print_r($students->result());
foreach($students->result() as $mStudent):
    $a++;
    //if($a==1):
    if($a==3):
       $y=167;
       $x=3;
    endif;
    

    $pdf->SetXY($x,$y);
    $pdf->SetFont('Times', 'B', 16);
    
    $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
    if($settings->set_logo!='noImage.png'):
        $pdf->Image($image_file, $x+15, $y, 16, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    else:
        $image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
        $pdf->Image($image_file, $x, $y, 16, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    endif;
    
    $pdf->SetXY($x,$y);
    $pdf->MultiCell(105,8, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->Ln();
    
    $pdf->SetFont('Times', 'N', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(105, 7, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'T');
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'b', 8);
    $pdf->SetX($x);
    $pdf->MultiCell(105, 5, 'CLASS CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(5);
    
    $pdf->SetFont('helvetica', 'b', 7);
    $pdf->SetX($x);
    $mn = ($mStudent->middlename==""?"":substr($mStudent->middlename, 0,1).'.');
    $pdf->MultiCell(12, 5, 'Name :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, strtoupper($mStudent->firstname.' '.$mn.' '.$mStudent->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, 'Grade Level :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, $mStudent->level.' - '.$section->section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $pdf->SetX($x);
    $pdf->MultiCell(10, 5, 'LRN :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, $mStudent->lrn==""?$mStudent->st_id:$mStudent->lrn,'B', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(20, 5, 'SY :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, $sy.' - '.($sy+1),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(10);
    
    $pdf->SetX($x+2);
    $pdf->MultiCell(33, 5, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(33, 5, strtoupper($term).' QUARTER',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(33, 5, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $mp = 0;
    foreach($subject_ids as $sp):
          $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
            $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, segment_5, $sy); 
        if($singleSub->parent_subject==18):
            $grd += $finalGrade->row()->final_rating;
            $mp+=1;
        endif;
        
        if($section->grade_id>=5 && $section->grade_id<=7):
            if($singleSub->subject_id==51):
                $tle = $finalGrade->row()->final_rating * .5;
            elseif($singleSub->subject_id==5):
                $comp = $finalGrade->row()->final_rating * .5;
            endif;
                $tleComTitle = 'EPP / Computer';
        endif;
        
        if($section->grade_id>=8 && $section->grade_id<=9):
            if($singleSub->subject_id==10):
                $tle = $finalGrade->row()->final_rating * .6;
            elseif($singleSub->subject_id==5):
                $comp = $finalGrade->row()->final_rating * .4;
            endif;
            $tleComTitle = 'TLE / Computer';
        elseif($section->grade_id==10 && $section->grade_id==11):    
            if($singleSub->subject_id==10):
                $tle = $finalGrade->row()->final_rating * .5;
            elseif($singleSub->subject_id==5):
                $comp = $finalGrade->row()->final_rating * .5;
            endif;
            $tleComTitle = 'TLE / Computer';
        endif;
        
        $tleComs = round(($tle + $comp), 0, PHP_ROUND_HALF_UP);
        $tleCom = $tleComs<=73?73:$tleComs==74?75:$tleComs;
        
    endforeach;
    $fg = round($grd/$mp);
    $grd = 0;

    $m = 0;
    $tc = 0;
    $numSubs=0;
        foreach($subject_ids as $sub):
          $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
            $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, segment_5, $sy); 
            $pdf->SetX($x+2);
            if($singleSub->parent_subject!=18 && $singleSub->parent_subject!=10):
                $pdf->MultiCell(33, 5,'     '.$singleSub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(33, 5, $finalGrade->row()->final_rating==""?"":$finalGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                if($finalGrade->row()->final_rating>=75):
                    $pdf->MultiCell(33, 5, 'PASSED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                else:
                    $pdf->MultiCell(33, 5, 'FAILED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                endif; 
                
                    $pdf->Ln();
            elseif($singleSub->subject_id==10 || $singleSub->subject_id==51):
                $tc++;
                if($tc==1):
                    $numSubs++;
                    $pdf->MultiCell(33, 5, "     ".$tleComTitle,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(33, 5, $tleCom,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(33, 5, ($tleCom>=75?'PASSED':'FAILED'),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();
                endif;    
            else:
                $m++;
                if($m==1):
                    $numSubs++;
                    $pdf->MultiCell(33, 5, "     MAPEH",1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(33, 5, $fg,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(33, 5, "",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();
                    $pdf->SetX($x+2);
                    $pdf->MultiCell(33, 5,'           '.$singleSub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(33, 5, $finalGrade->row()->final_rating==""?"":$finalGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    if($finalGrade->row()->final_rating>=75):
                        $pdf->MultiCell(33, 5, 'PASSED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    else:
                        $pdf->MultiCell(33, 5, 'FAILED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif; 

                    $pdf->Ln();
                else:
                    if($singleSub->parent_subject!=10):
                        $pdf->MultiCell(33, 5,'           '. $singleSub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(33, 5, $finalGrade->row()->final_rating==""?"":$finalGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        if($finalGrade->row()->final_rating>=75):
                            $pdf->MultiCell(33, 5, 'PASSED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        else:
                            $pdf->MultiCell(33, 5, 'FAILED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        endif; 

                        $pdf->Ln();
                    endif;
                endif;
                
            endif;
            
            
            if($singleSub->parent_subject!=18 && $singleSub->parent_subject!=10):
                $genAve += $finalGrade->row()->final_rating;
                $numSubs++;
            endif;

        endforeach;
        $genAve += $fg+$tleCom;
        $pdf->SetX($x+2);
        $pdf->MultiCell(99, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $pdf->SetX($x+2);
        $pdf->MultiCell(33, 5, 'GENERAL AVERAGE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(33, 5, round($genAve/($numSubs)),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        if(round($genAve/($numSubs),3) >=75):
            $pdf->MultiCell(33, 5, 'PASSED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        else:
            $pdf->MultiCell(33, 5, 'FAILED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        
        
        $attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $mStudent->st_id, $section->grade_id, $this->session->school_year);
        
        $pdf->Ln(8);
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(99, 5, 'REPORT ON ATTENDANCE',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetX($x+2);
        $pdf->MultiCell(55, 5, 'ATTENDANCE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(11, 5, $month1,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $month2,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $month3,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(11, 5, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        

        $pdf->SetX($x+2);
        $pdf->MultiCell(55, 5, 'SCHOOL DAYS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(11, 5, $totalDaysInAMonth1,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $totalDaysInAMonth2,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $totalDaysInAMonth3,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(11, 5, $totalDays,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

//        $pdays1 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m1, $y1, $sy);
//        $pdays2 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m2, $y2, $sy);
//        $pdays3 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m3, $y3, $sy);
//        
        $totalPDays = $attendance->$m1+$attendance->$m2+$attendance->$m3;
        
        
        $tardy1= Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, $m1, $sy);
        $tardy2= Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, $m2, $sy);
        $tardy3= Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, $m3, $sy);
        
        $totalTardy = $tardy1->num_rows()+$tardy2->num_rows()+$tardy3->num_rows();
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(55, 5, 'DAYS PRESENT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(11, 5, $totalDaysInAMonth1<$attendance->$m1?$totalDaysInAMonth1:$attendance->$m1,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $totalDaysInAMonth2<$attendance->$m2?$totalDaysInAMonth1:$attendance->$m2,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $totalDaysInAMonth3<$attendance->$m3?$totalDaysInAMonth3:$attendance->$m3,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(11, 5, $totalDays<$totalPDays?$totalDays:$totalPDays,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetX($x+2);
        $pdf->MultiCell(55, 5, 'DAYS TARDY',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(11, 5, $tardy1->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $tardy2->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, $tardy3->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(11, 5, $totalTardy,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(10);
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(99, 5, $adv,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(25, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(49, 5, 'CLASS ADVISER','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    //endif;

        
        unset($fg);
        unset($genAve);
        unset($numSubs);
        unset($total);
        $x = $x+107;
endforeach;

$pdf->Output('class_card.pdf', 'I');
