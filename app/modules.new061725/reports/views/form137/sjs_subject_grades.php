<?php
$style3 = array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => 'black');
$currentLevel = Modules::run('reports/getCurrentSPR_level', base64_decode(segment_3), '');

$level = Modules::run('registrar/getGradeLevelById', $currentLevel->row()->grade_level_id);
if($school_year==""):
    $pdf->Line($x+35, $y+8, $slashx, $slashy , array('color' => 'black','width' => .5));
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->SetTextColor(127);
    $pdf->Text($x+45, $y+35, 'NO     ENTRY');
    $level = "";
endif;
//loop through each year
$nextYear = $school_year + 1;
if($school_year!="" || $school_year!=NULL):
    $sy = $school_year.' - '.$nextYear;
    $level = $level->level;
else:
    
    $sy = "";
endif;
$pdf->setCellPaddings(0.5,0.5,0.5,0.5);
$pdf->SetTextColor(0);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetLineWidth(.2);

$pdf->Rect($x, $y, 100, 77.5, 'D', array('all' => $style3));

$pdf->setXY($x, $y-10);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetLineWidth(.2);
$pdf->MultiCell(20, 5, 'Year Level :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 5, strtoupper($level),0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(27, 5, 'School Year :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(19, 5, $sy,0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln();
$pdf->setX($x);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(20, 5, 'School :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(60, 5, $school,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln();
$pdf->setX($x);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(35, 7.5, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 7.5, 'M');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->setCellPaddings(0,0,0,0);
$pdf->MultiCell(35, 4, 'GRADING PERIODS','LTR', 'C', 0, 0, '', '', true, 0, false, true, 4, 'B');
$pdf->MultiCell(15, 7.5, 'FINAL 
GRADE',1, 'C', 0, 0, '', '', true, 0, false, true, 7.5, 'M');
$pdf->MultiCell(15, 7.5, 'ACTION
TAKEN',1, 'C', 0, 0, '', '', true, 0, false, true, 7.5, 'M');

$pdf->Ln(4.5);
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell($gradingPeriods, 2.9, '','', 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(8.75, 2.9, '1',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(8.75, 2.9, '2',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(8.75, 2.9, '3',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(8.75, 2.9, '4',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');

//loop through each subject
$pdf->setCellPaddings(1,1,1,1);
foreach ($subjects as $s){
    $singleSub = Modules::run('academic/getSpecificSubjects', $s);
    $ar = Modules::run('reports/getSPRecords',$user_id, $level_id, $singleSub->subject_id);
    $nextYear = $school_year+1;
    $first = Modules::run('reports/getGrade', $ar->row()->first);
    $second = Modules::run('reports/getGrade', $ar->row()->second);
    $third = Modules::run('reports/getGrade', $ar->row()->third);
    $fourth = Modules::run('reports/getGrade', $ar->row()->fourth);
    
    if($ar->row()->fourth!=0):
        $division = 4;
        $ave = round(($ar->row()->first+$ar->row()->second+$ar->row()->third+$ar->row()->fourth)/$division, 2);
    else:
        $ave = '';
    endif;
    $l_ave = Modules::run('reports/getGrade', $ave);
    $final = number_format($ave,2).' / '.$l_ave;
    $generalFinal += $ave;
    if($ave>74):
        $AT = 'passed';
    else:    
        $AT = 'failed';
    endif;
    if($ar->row()->fourth==0):
            $final = '';
            $AT = "";
        endif;
        $pdf->Ln();
        $pdf->setX($x);
        $pdf->SetFont('helvetica', 'N', 7);
        if($s!=10):
            $pdf->MultiCell(35, 5,strtoupper($singleSub->subject),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        else:
            $pdf->MultiCell(35, 5,strtoupper($singleSub->short_code),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        $pdf->SetFont('helvetica', 'N', 6);
        $pdf->MultiCell(8.75, 5, $first,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
        $pdf->MultiCell(8.75, 5, $second,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
        $pdf->MultiCell(8.75, 5, $third,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
        $pdf->MultiCell(8.75, 5, $fourth,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
        $pdf->MultiCell(15, 5, $final ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, $AT,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
}

    $cc_first = Modules::run('gradingsystem/co_curricular/getCoCurricular', $user_id, 1);
    $cc_second = Modules::run('gradingsystem/co_curricular/getCoCurricular', $user_id, 2);
    $cc_third = Modules::run('gradingsystem/co_curricular/getCoCurricular', $user_id, 3);
    $cc_fourth = Modules::run('gradingsystem/co_curricular/getCoCurricular', $user_id, 4);
    $ccFinal = ($cc_first->rate+$cc_second->rate+$cc_third->rate+$cc_fourth->rate)/4;
    
    if($school_year!=""):
        $generalFinals = (($generalFinal/count($subjects))*.7)+($ccFinal*.3);
        $l_genAve = Modules::run('reports/getGrade', $ave);
        if($generalFinals>74):
            $AT = 'Passed';
        else:    
            $AT = 'failed';
        endif;
        $classified = strtoupper($classified);
        $finals=number_format(round($generalFinals, 2),2).' / '.$l_genAve;
    else:
        $finals ="";
        $yearToDate = '';
        $classified='';
    endif;
$pdf->Ln();
$pdf->setX($x);
$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(35, 5, 'GENERAL AVERAGE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->setCellPaddings(0,0,0,0);
$pdf->MultiCell(35, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(15, 5, $finals,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, $AT,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->setX($x);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(20, 5, 'Classified As :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 5, $classified,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

//Day of School
if($days['schoolDays']!=""):
    $schoolDays = $days['schoolDays']->row();
    $schoolDaysTotal = $schoolDays->June+$schoolDays->July+$schoolDays->August+$schoolDays->September+$schoolDays->October+$schoolDays->November+$schoolDays->December+$schoolDays->January+$schoolDays->February+$schoolDays->March;
endif;

if($days['schoolDays']!=""):
    $daysPresent = $days['exist']->row();
    $presentDaysTotal = $daysPresent->June+$daysPresent->July+$daysPresent->August+$daysPresent->September+$daysPresent->October+$daysPresent->November+$daysPresent->December+$daysPresent->January+$daysPresent->February+$daysPresent->March;
endif;

$pdf->SetLineWidth(.5);

$pdf->Ln(4);
$pdf->setX($x);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, ' Total Days in School','LT', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':','T', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(55, 5, $schoolDaysTotal,'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(3);
$pdf->setX($x);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, ' Total Days Present','L', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(55, 5, $presentDaysTotal,'R', 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(3);
$pdf->setX($x);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(40, 5, ' Total number of years to Date','LB', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':','B', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(55, 5, $yearToDate,'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, '');