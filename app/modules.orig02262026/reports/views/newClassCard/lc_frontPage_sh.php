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

$strand_id = $this->uri->segment(8);
$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_4);
$coreSubs = Modules::run('subjectmanagement/getSHSubjects', $section->grade_id, $sem, $strand_id, 1);  
$appliedSubs = Modules::run('subjectmanagement/getSHSubjects', $section->grade_id, $sem, $strand_id);  
$students = Modules::run('registrar/getStudentForCard', segment_7,segment_6, segment_4);
$sy = $this->session->userdata('school_year');

$sd = Modules::run('reports/getRawSchoolDays', $sy);

switch (segment_5){
     case 1:
     case 2:
         $sem = 1;
         $term = 'First';
         $one = '1';
         $two = '2';
         $month1 = 'JUN';
         $mn1 = 6;
         $month2 = 'JULY';
         $mn2 = 7;
         $month3 = 'AUG';
         $mn3 = 8;
         $month4 = 'SEPT';
         $mn4 = 9;
         $month5 = 'OCT';
         $mn5 = 10;
         
         $schoolDays1 = $sd->row()->June;
         $schoolDays2 = $sd->row()->July;
         $schoolDays3 = $sd->row()->August;
         $schoolDays4 = $sd->row()->September;
         $schoolDays5 = $sd->row()->October;
     break;
     case 3:
     case 4:
         $sem = 2;
         $term = 'Second';
         $one = '3';
         $two = '4';
         $month1 = 'NOV';
         $mn1 = 11;
         $month2 = 'DEC';
         $mn2 = 12;
         $month3 = 'JAN';
         $mn3 = 1;
         $month4 = 'FEB';
         $mn4 = 2;
         $month5 = 'MARCH';
         $mn5 = 3;
         $schoolDays1 = $sd->row()->November;
         $schoolDays2 = $sd->row()->December;
         $schoolDays3 = $sd->row()->January;
         $schoolDays4 = $sd->row()->February;
         $schoolDays5 = $sd->row()->March;
     break;
}


        $totalDaysInAMonth1 = $schoolDays1;
        $totalDaysInAMonth2 = $schoolDays2;
        $totalDaysInAMonth3 = $schoolDays3;
        $totalDaysInAMonth4 = $schoolDays4;
        $totalDaysInAMonth5 = $schoolDays5;
        
        $totalDays = $totalDaysInAMonth1 + $totalDaysInAMonth2 + $totalDaysInAMonth3 + $totalDaysInAMonth4 +$totalDaysInAMonth5;
    
$x=3;
$y=5;
$a=0;

//print_r($students->result());
foreach($students->result() as $mStudent):
    $a++;
    
    if($a==3):
       $y=165;
       $x=3;
    endif;
    

    $pdf->SetXY($x,$y);
    $pdf->SetFont('Times', 'B', 16);
    
    $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
    if($settings->set_logo!='noImage.png'):
        $pdf->Image($image_file, $x+15, $y-1, 16, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
    $pdf->MultiCell(105, 5, 'SENIOR HIGH SCHOOL CLASS CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
    $pdf->MultiCell(45, 10, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 5, 'Quarter',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 10, 'Semester Final Grade',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->SetXY($x+47, $y+38);
    $pdf->MultiCell(15, 5, $one,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, $two,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->SetFillColor(150, 166, 234);
    $pdf->Ln();
    $pdf->SetX($x+2);
    $pdf->MultiCell(100, 5, 'Core Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $mp = 0;
    $m = 0;
    foreach($coreSubs as $sub):
     
            $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
            $firstGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $one, $sy); 
            $secondGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $two, $sy); 
            $pdf->Ln();
            $pdf->SetX($x+2);
            if($sub->is_core):
                $mp++;
                $pdf->SetFont('helvetica', 'b', 8);
                $pdf->MultiCell(45, 5,'     '.$sub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
            if($sub->is_core):
                if($firstGrade->row()->final_rating!=""):
                    $pdf->MultiCell(15, 5, $firstGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, $secondGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $coreTotal += round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2);
                else:
                    $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                endif; 
            endif; 
            
    endforeach;
    $pdf->Ln();
    $pdf->SetX($x+2);
    $pdf->SetFont('helvetica', 'b', 9);
    $pdf->MultiCell(100, 5, 'Applied and Specialized Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');   
    
    foreach($appliedSubs as $sub):
            $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
            $firstGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $one, $sy); 
            $secondGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $two, $sy); 
            $pdf->Ln();
            $pdf->SetX($x+2);
            $pdf->SetFont('helvetica', 'b', 8);
            $pdf->MultiCell(45, 5,'     '.$sub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $mp++;
            if($firstGrade->row()->final_rating!=""):
                $pdf->MultiCell(15, 5, $firstGrade->row()->final_rating==""?"":$firstGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, ($secondGrade->row()->final_rating==''?'':$secondGrade->row()->final_rating),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(25, 5, round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $appliedTotal += round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2);
            else:
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif; 
            

    endforeach; 
            $genTotal = $coreTotal + $appliedTotal;
            $genAve = round($genTotal/$mp, 2);
            $pdf->Ln();
            $pdf->SetX($x+2);
            $pdf->MultiCell(100, 5, '',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');$pdf->Ln();
            $pdf->SetX($x+27);
            $pdf->SetFont('helvetica', 'b', 7);
            $pdf->MultiCell(50, 5, 'General Average for the Semester',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(25, 5, $genAve,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
            unset($mp);
        unset($coreTotal);
        unset($appliedTotal);
        
        
        $pdf->Ln(6);
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(99, 5, 'REPORT ON ATTENDANCE',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetX($x+2);
        $pdf->MultiCell(39, 5, 'ATTENDANCE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(10, 5, $month1,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month2,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month3,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month4,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month5,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(10, 5, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        

        $pdf->SetX($x+2);
        $pdf->MultiCell(39, 5, 'SCHOOL DAYS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(10, 5, $month1,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month2,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month3,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month4,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month5,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(10, 5, $totalDays,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdays1 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m1, date('Y'), $sy);
        $pdays2 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m2, date('Y'), $sy);
        $pdays3 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m3, date('Y'), $sy);
        $pdays4 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m4, date('Y'), $sy);
        $pdays5 = Modules::run('attendance/getIndividualMonthlyAttendance', $mStudent->st_id, $m5, date('Y'), $sy);
        
        $totalPDays = $pdays1+$pdays2+$pdays3+$pdays4+$pdays5;
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(39, 5, 'DAYS PRESENT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(10, 5, $totalDaysInAMonth1<$pdays1?$totalDaysInAMonth1:$pdays1,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $totalDaysInAMonth2<$pdays2?$totalDaysInAMonth2:$pdays2,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $totalDaysInAMonth3<$pdays3?$totalDaysInAMonth3:$pdays3,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $totalDaysInAMonth4<$pdays4?$totalDaysInAMonth4:$pdays4,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $totalDaysInAMonth5<$pdays5?$totalDaysInAMonth5:$pdays5,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(10, 5, $totalPDays,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetX($x+2);
        $pdf->MultiCell(39, 5, 'DAYS TARDY',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(10, 5, $month1,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month2,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month3,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month4,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, $month5,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 6.5);
        $pdf->MultiCell(10, 5, $totalDays,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(8);
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(99, 5, $adv,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(25, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(49, 5, 'CLASS ADVISER','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        
        $x = $x+107;
endforeach;



$pdf->Output('class_card.pdf', 'I');
