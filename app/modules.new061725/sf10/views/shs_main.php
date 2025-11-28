<?php

// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
// ------------------------------ SCHOLASTIC RECORD ------------------------------

if ($i == 2):
    $pdf->AddPage();
    $pdf->SetY(5);
endif;

if($pdf->PageNo()==2):
    $gradeName = 'Grade Twelve ';
    $gradeCode = 'G12';
else:
    $gradeName = 'Grade Eleven ';
    $gradeCode = 'G11';
endif;


$pdf->SetAlpha(0.05);
$pdf->Image(K_PATH_IMAGES . '/pilgrim.jpg', 25, 70, 200, 200,'','JPG');
$pdf->SetAlpha(1);

switch ($i):
    case 0:
    case 2:
        $sem = 1;
        $grade1 = 'first';
        $grade2 = 'second';
        break;
    case 1:
    case 3:
        $sem = 2;
        $grade1 = 'third';
        $grade2 = 'fourth';
        break;
endswitch;

$stID = $student->sprp_st_id;
$sRec = Modules::run('sf10/getSPRrec', $stID, $sYear, $sem);
$str_id = Modules::run('sf10/getStrand', $strand, 2);
$s_firstAdd = Modules::run('sf10/getAddress', $sRec->st_id, ($sem+1), $sYear);

if ($i == 2):
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(12, 5, "NAME:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, strtoupper($student->sprp_lastname . ', ' . $student->sprp_firstname . ' ' . ($student->sprp_middlename != '' ? substr($student->sprp_middlename, 0, 1) . '.' : '')), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
endif;

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(230, 5, ($i == 0 || $i == 2 ? "F I R S T   S E M E S T E R" : "S E C O N D   S E M E S T E R"), '', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(23, 4, "Track / Strand:", '', 'L', 0, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(102, 4, $str_id->strand, '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$section = ($sRec->section!=""?" - ".$sRec->section:"");

$pdf->MultiCell(73, 4, $gradeName.$section, '', 'L', 0, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(40, 4, '', '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, "School Year:", '', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, $sYear.' - '.($sYear+1), '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$pdf->MultiCell(23, 4, "School:", '', 'L', 0, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(90, 4, strtoupper($student->school_name), '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, "Address:", '', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(100, 4, ucwords(strtolower(($s_firstAdd->street!=NULL?$s_firstAdd->street.' ':'') . $s_firstAdd->barangay_id . ' ' . $s_firstAdd->mun_city . ', ' . $s_firstAdd->province . ', ' . $s_firstAdd->zip_code)), '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(5);

// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------


$aRec = Modules::run('sf10/getAcademicRecords', $sRec->spr_id, $sYear, $sRec->grade_level_id, $sem);
$getAcadAverage = Modules::run('sf10/getAcadAverage', $sRec->spr_id, $sem);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(30, 12, "GRADE", '1', 'C', 1, 0, '10', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(115, 12, "SUBJECTS", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(40, 6, "Quarter", '1', 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(25, 12, "Final Grade", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(20, 12, "REMARKS", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(6);

$pdf->MultiCell(30, 6, '', '', 'C', 0, 0, '10', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(115, 6, "", '', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(20, 6, "1st", 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(20, 6, "2nd", 1, 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(25, 6, "", '', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(20, 6, "", '', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$totalSubj = 0;
$isCore = '';
$totalCoreGrade = 0;
$totalAplSemGrade = 0;
$pdf->SetFont('helvetica', 'R', 8);
$pdf->SetFillColor(255, 255, 255);
$failCount = 0;

if ($aRec->result()):
    foreach ($aRec->result() as $sl):
        if ($sl->sem == $sem):
            if(is_numeric($sl->$grade1) || is_numeric($sl->$grade2)):
                $totalSubj++;
            endif;
            if($sl->subject_id!=0):
                $pdf->MultiCell(30, 4, $gradeCode, '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(115, 4, $sl->subject, '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
                if(is_numeric($sl->$grade1)):
                   $pdf->MultiCell(20, 4, $sl->$grade1!=0?$sl->$grade1:"", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M'); 
                else:    
                   $pdf->MultiCell(20, 4, $sl->$grade1, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M'); 
                endif;
                if(is_numeric($sl->$grade2)):
                   $pdf->MultiCell(20, 4, $sl->$grade2!=0?$sl->$grade2:"", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M'); 
                   $pdf->MultiCell(25, 4, ($sl->$grade2>0? round($sl->avg):""), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M'); 
                else:    
                   $pdf->MultiCell(20, 4, $sl->$grade2, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M'); 
                   $pdf->MultiCell(25, 4, ($sl->$grade2!=''?$sl->avg:""), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M'); 
                endif;
                
                $pdf->MultiCell(20, 4, ($sl->avg > 0?$sl->avg > 74?"PASSED":"FAILED":""), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->Ln();
                
                $aveSub += ($sl->$grade2!=0?$sl->avg:0);
                (is_numeric($sl->avg)?($sl->avg > 0?$sl->avg > 74?"PASSED":$failCount++:""):$sl->avg!=""?"PASSED":"");
            endif;    
            
        endif;
    endforeach;
    
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(30, 4, '', '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(115, 4, '', '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(25, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(30, 4, '', '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(115, 4, '', '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(25, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->Ln();
    
    if($getAcadAverage->avg!=NULL):
        $generalAve = $getAcadAverage->avg;
    else:
        $generalAve = round(($aveSub/$totalSubj), 2, PHP_ROUND_HALF_UP );
    endif;

    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(30, 4, '', '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(115, 4, 'General Average', '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4,'', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(25, 4,($generalAve!=0?round($generalAve,0):'') , '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, ($generalAve > 0?($generalAve>=75?"PASSED":"FAILED"):''), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->Ln();

else:
    for ($b = 0; $b < 12; $b++):
        $pdf->MultiCell(30, 4, '', '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(115, 4, '', '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(25, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->Ln();
    endfor;
endif;

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 4, '', '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(115, 4, '', '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(25, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(30, 4, "", 'LR', 'L', 0, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? 'June' : 'Nov.'), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? 'July' : 'Dec.'), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? 'Aug.' : 'Jan.'), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? 'Sept.' : 'Feb.'), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? 'Oct.' : 'Mar.'), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(45, 4, 'TOTAL', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
//$pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

if($sYear == $this->session->school_year):
    $schoolDays = Modules::run('sf10/getRawSchoolDays',$sYear)->row();
    
else:    
    $schoolDays = Modules::run('sf10/getPreviousSchoolDays',$student->school_name, $sYear );
endif;

$sfirstTotal = ($schoolDays?$schoolDays->June:0) + ($schoolDays?$schoolDays->July:0) + ($schoolDays?$schoolDays->August:0 )+($schoolDays?$schoolDays->September:'')+($schoolDays?$schoolDays->October:'');
$ssecondTotal = ($schoolDays?$schoolDays->November:0) + ($schoolDays?$schoolDays->December:0) + ($schoolDays?$schoolDays->January:0 )+($schoolDays?$schoolDays->February:'')+($schoolDays?$schoolDays->March:'');


$pdf->MultiCell(30, 4, "Days of School:", 'LR', 'L', 0, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($schoolDays?$schoolDays->June:'') : ($schoolDays?$schoolDays->November:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($schoolDays?$schoolDays->July:'') : ($schoolDays?$schoolDays->December:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($schoolDays?$schoolDays->August:'') : ($schoolDays?$schoolDays->January:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($schoolDays?$schoolDays->September:'') : ($schoolDays?$schoolDays->February:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($schoolDays?$schoolDays->October:'') : ($schoolDays?$schoolDays->March:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(45, 4, ($i == 0 || $i == 2 ?$sfirstTotal:$ssecondTotal), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
//$pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$attendancePresent = Modules::run('sf10/getAttendanceOveride',$sRec->spr_id, $sYear);

$firstTotal = ($attendancePresent?$attendancePresent->row()->June:0) + ($attendancePresent?$attendancePresent->row()->July:0) + ($attendancePresent?$attendancePresent->row()->August:0 )+($attendancePresent?$attendancePresent->row()->September:'')+($attendancePresent?$attendancePresent->row()->October:'');
$secondTotal = ($attendancePresent?$attendancePresent->row()->November:0) + ($attendancePresent?$attendancePresent->row()->December:0) + ($attendancePresent?$attendancePresent->row()->January:0 )+($attendancePresent?$attendancePresent->row()->February:'')+($attendancePresent?$attendancePresent->row()->March:'');


$pdf->MultiCell(30, 4, "Days Present:", 'BLR', 'L', 0, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($attendancePresent?$attendancePresent->row()->June:'') : ($attendancePresent?$attendancePresent->row()->November:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($attendancePresent?$attendancePresent->row()->July:'') : ($attendancePresent?$attendancePresent->row()->December:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($attendancePresent?$attendancePresent->row()->August:'' ): ($attendancePresent?$attendancePresent->row()->January:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($attendancePresent?$attendancePresent->row()->September:'') : ($attendancePresent?$attendancePresent->row()->February:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(31, 4, ($i == 0 || $i == 2 ? ($attendancePresent?$attendancePresent->row()->October:'') : ($attendancePresent?$attendancePresent->row()->March:'')), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(45, 4, ($i == 0 || $i == 2 ?$firstTotal:$secondTotal), '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
//$pdf->MultiCell(20, 4, "", 0, 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$pdf->MultiCell(15, 4, "Remarks:", '0', 'L', 0, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(182, 4,($generalAve!=0?($failCount==0?'PROMOTED':''):''), '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(6);


