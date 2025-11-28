<?php

// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
// ------------------------------ SCHOLATIC RECORD ------------------------------
if ($i == 2):
    $pdf->AddPage();
    $pdf->SetY(5);
endif;
//if ($nYear > $year):
//    $sYear = '';
//else:
//    $sYear = $nYear;
//endif;

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
$failed = [];

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(10, 5, "School:", 'LT', 'L', 0, 0, $x, $y, true, 0, false, true, 5, 'M');
$pdf->MultiCell(80, 5, ($sYear == '' ? '' : strtoupper($sRec->school_name)), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(12, 5, "School ID:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, ($sYear == '' ? '' : $sRec->school_id), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "Grade Level:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, ($sYear == '' ? '' : strtoupper($sRec->grade_level_id - 1)), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(10, 5, "SY:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, ($sYear == '' ? '' : $sYear . ' - ' . ($sYear + 1)), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(10, 5, "SEM:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(23, 5, ($i == 0 || $i == 2 ? 'First Sem' : 'Second Sem'), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(18, 5, "Track / Strand :", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(90, 5, $str_id->strand, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "Section:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(102, 5, $sRec->section, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 2, "", 'BLR', 'L', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln(3);
// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------


$aRec = Modules::run('sf10/getAcademicRecords', $sRec->spr_id, $sYear, $sRec->grade_level_id, $sem);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(30, 12, "Indicate if Subject is CORE, APPLIED or SPECIALIZED", '1', 'C', 1, 0, '10', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(115, 12, "SUBJECTS", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(40, 6, "Quarter", '1', 'C', 1, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(25, 12, "SEM FINAL GRADING", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(20, 12, "ACTION TAKEN", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
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
$pdf->SetFont('helvetica', 'R', 6);
$pdf->SetFillColor(255, 255, 255);

if (count($aRec->result()) > 2):
    foreach ($aRec->result() as $sl):
        if ($sl->sem == $sem):
            $totalSubj++;
//        if ($sl->is_core == 1):
            $pdf->MultiCell(30, 4, ($sl->is_core == 1 ? 'CORE' : 'APPLIED'), '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(115, 4, $sl->subject_id, '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(20, 4, $sl->$grade1, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(20, 4, $sl->$grade2, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $coreSemGrade = round(($sl->$grade1 + $sl->$grade2) / 2, 2);
            if ($coreSemGrade < 75 && $coreSemGrade != 0):
                $failed[] += $sl->subject_id;
            endif;
            $totalCoreGrade += $coreSemGrade;
            $pdf->MultiCell(25, 4, $coreSemGrade, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
            $pdf->Ln();
//        endif;
//    endforeach;
//    foreach ($aRec->result() as $sl):
//        if ($sl->is_core != 1):
//            $pdf->MultiCell(30, 4, 'APPLIED', '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
//            $pdf->MultiCell(115, 4, $sl->subject, '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
//            $pdf->MultiCell(20, 4, $sl->first, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
//            $pdf->MultiCell(20, 4, $sl->second, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
//            $aplSemGrade = round(($sl->first + $sl->second) / 2, 2);
//            $totalAplSemGrade += $aplSemGrade;
//            $pdf->MultiCell(25, 4, $aplSemGrade, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
//            $pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
//            $pdf->Ln();
//        endif;
        endif;
    endforeach;

    $pdf->SetFillColor(191, 191, 191);
    $pdf->MultiCell(185, 4, 'General Ave. for the Semester: ', '1', 'R', 1, 0, '10', '', true, 0, false, true, 4, 'M');
    $pdf->SetFillColor(255, 255, 255);
    $genAveSem = round(($totalCoreGrade + $totalAplSemGrade) / $totalSubj, 1);
    $pdf->MultiCell(25, 4, $genAveSem, '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
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

$pdf->Ln(6);
$pdf->MultiCell(20, 4, "REMARKS:", '0', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(210, 4, $sRec->remarks, 'B', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(6);

$pdf->MultiCell(70, 4, "Prepared by:", '0', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(70, 4, "Certified True and Correct:", '0', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(70, 4, "Date Checked (MM/DD/YYYY):", '0', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(12);

$pdf->MultiCell(65, 4, "Signature of Adviser over Printed Name", 'T', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(10, 4, "", '0', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(90, 4, "Signature of Authorized Person over Printed Name, Designation", 'T', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(10, 4, "", '0', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(55, 4, "", 'T', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$pdf->MultiCell(27, 4, "REMEDIAL CLASSES", '', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(39, 4, "Conducted from (MM/DD/YYYY):", '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, "", 'B', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(23, 4, "to (MM/DD/YYYY):", '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(20, 4, "", 'B', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(11, 4, "School:", '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(60, 4, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(15, 4, "School ID:", '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(15, 4, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(6);

$pdf->SetFillColor(191, 191, 191);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(30, 12, "Indicate if Subject is CORE, APPLIED or SPECIALIZED", '1', 'C', 1, 0, '10', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(115, 12, "SUBJECTS", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(20, 12, "SEM FINAL GRADE", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(20, 12, "REMEDIAL CLASS MARK", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(25, 12, "RECOMPUTED FINAL GRADING", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(20, 12, "ACTION TAKEN", '1', 'C', 1, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 7);
if (count($failed) > 0):
    foreach ($failed as $f):
        foreach ($aRec->result() as $a):
            if ($a->subject_id == $f):
                $rfGrade = Modules::run('sf10/getRFGrade', $sRec->spr_id, $f);
                if ($rfGrade->rfGrade >= 75):
                    $fAve = round(($a->$grade1 + $a->$grade2) / 2, 1);

                    $pdf->SetFont('helvetica', 'B', 7);
                    $pdf->MultiCell(30, 4, ($a->is_core == 1 ? 'CORE' : 'APPLIED'), '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
                    $pdf->MultiCell(115, 5, $a->subject, '1', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, $fAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, $rfGrade->rfGrade, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, ($rfGrade->rfGrade < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();
                endif;
            endif;
        endforeach;
    endforeach;
else:
    for ($a = 0; $a < 3; $a++):
        $pdf->MultiCell(30, 4, '', '1', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(115, 4, '', '1', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(20, 4, '', '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(25, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(20, 4, "", '1', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->Ln();
    endfor;
endif;
