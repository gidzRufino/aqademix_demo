<?php

// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
// ------------------------------ SCHOLATIC RECORD ------------------------------
if ($i == 2):
    $pdf->AddPage();
    $pdf->SetY(5);
endif;
if ($nYear > $year):
    $sYear = '';
else:
    $sYear = $nYear;
endif;
$stID = $student->sprp_st_id;

$dbExist = Modules::run('sf10/checkIFdbExist', $sYear);


$sRec = Modules::run('sf10/getSPRrec', $stID, $sYear);
if ($dbExist == 1):
    $pdf->SetFont('helvetica', '', 6);
    $pdf->MultiCell(12, 5, "School:", 'LT', 'L', 0, 0, $x, $y, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(70, 5, ($sYear == '' ? '' : strtoupper($sRec->school_name)), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(18, 5, "School ID:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, ($sYear == '' ? '' : $sRec->school_id), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "District:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, ($sYear == '' ? '' : strtoupper($sRec->district)), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Division:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, ($sYear == '' ? '' : strtoupper($sRec->division)), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Region:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, ($sYear == '' ? '' : strtoupper($sRec->region)), 'BTR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', '', 6);
    $pdf->MultiCell(31, 5, "Classified as Grade:", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, ($sYear == '' ? '' : strtoupper(levelDesc($sRec->grade_level_id))), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Section:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, ($sYear == '' ? '' : strtoupper($sRec->section)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(21, 5, "School Year:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, ($sYear == '' ? '' : $sYear . '-' . ($sYear + 1)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(30, 5, "Name of Adviser/Teacher:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(39, 5, ($sYear == '' ? '' : strtoupper($sRec->spr_adviser)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(18, 5, "Signature:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, "", 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(230, 2, "", 'BLR', 'L', 0, 0, '10', '', true, 0, false, true, 2, 'M');
    $pdf->Ln(3);
// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------

    $aRec = Modules::run('sf10/getAcademicRecords', $stID, $sYear, $sRec->grade_level_id);

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(90, 13, "LEARNING AREAS", '1', 'C', 0, 0, '10', '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(80, 8, "Quarterly Meeting", '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 13, "FINAL RATING", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(40, 13, "REMARKS", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(10, 8, "", '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();

    $pdf->MultiCell(90, 5, '', 'BL', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
// ------------------------------ LEARNING AREAS ------------------------------
// ------------------------------ SUBJECT 1 ------------------------------
    $mapeh1 = 0;
    $mapeh2 = 0;
    $mapeh3 = 0;
    $mapeh4 = 0;

    foreach ($aRec->result() as $ar):
        if ($ar->parent_subject == 11):
            $mapeh1 += $ar->first;
            $mapeh2 += $ar->second;
            $mapeh3 += $ar->third;
            $mapeh4 += $ar->fourth;
        //$aveMapeh = ($mapeh1 + $mapeh2 + $mapeh3 + $mapeh4) / 4;
        endif;
    endforeach;

    $m1 = round($mapeh1 / 4);
    $m2 = round($mapeh2 / 4);
    $m3 = round($mapeh3 / 4);
    $m4 = round($mapeh4 / 4);

    $t = 0;
    $gAve = 0;
    if (count($aRec->result()) != 0 && count($aRec->result()) != 1 && $sYear != ''):
        foreach ($aRec->result() as $ar):
            if ($ar->parent_subject == 11):
                if ($ar->subject_id == 13):
                    $pdf->SetFont('helvetica', 'B', 7);
                    $pdf->MultiCell(90, 5, 'MAPEH', 'BL', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 7);
                    $pdf->MultiCell(20, 5, $m1, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, $m2, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, $m3, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, $m4, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 7);
                    $aveMapeh = ($m1 + $m2 + $m3 + $m4) / 4;
                    $pdf->MultiCell(20, 5, $aveMapeh, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(40, 5, ($aveMapeh < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();
                endif;
                $pdf->MultiCell(90, 5, '     ' . $ar->subject, 'BL', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 7);
                $pdf->MultiCell(20, 5, $ar->first, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, $ar->second, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, $ar->third, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, $ar->fourth, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 7);
                $mapehAve = ($ar->first + $ar->second + $ar->third + $ar->fourth) / 4;
                $pdf->MultiCell(20, 5, $mapehAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(40, 5, ($mapehAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            else:
                $t++;
                $pdf->SetFont('helvetica', 'B', 7);
                $pdf->MultiCell(90, 5, $ar->subject, 'BL', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 7);
                $pdf->MultiCell(20, 5, $ar->first, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, $ar->second, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, $ar->third, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, $ar->fourth, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 7);
                $subjAve = ($ar->first + $ar->second + $ar->third + $ar->fourth) / 4;
                $pdf->MultiCell(20, 5, $subjAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(40, 5, ($subjAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $gAve += $subjAve;
            endif;
            $pdf->Ln();
        endforeach;
    else:
        $pdf->SetAlpha(0.3);
        if ($i == 0):
            $pdf->Image(base_url() . 'images/forms/watermark.png', $x + 30, $y + 140, 150, 40);
        else:
            $pdf->Image(base_url() . 'images/forms/watermark.png', $x + 30, $y + 40, 150, 40);
        endif;
        for ($empty = 1; $empty < 15; $empty++):
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->MultiCell(90, 5, '', 'BL', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', '', 7);
            $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', '', 7);
            $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endfor;
        $pdf->SetAlpha(1);
    endif;

// ------------------------------ SUBJECT 12 ------------------------------
// ------------------------------ GENERAL AVERAGE ------------------------------
    $genAve = round(($gAve + $aveMapeh) / ($t + 1), 2);
    $pdf->SetFont('helvetica', 'BI', 7);
    $pdf->MultiCell(90, 5, "", 'L', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(80, 5, "GENERAL AVERAGE", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(20, 5, $genAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, ($genAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
// ------------------------------ GENERAL AVERAGE ------------------------------


    $pdf->MultiCell(230, 2, "", '1', 'C', 1, 0, '10', '', true, 0, false, true, 2, 'M');
    $pdf->Ln();

// ------------------------------ GENERAL AVERAGE ------------------------------
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(80, 5, "Remedial Classes", 'L', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "Conducted From (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(30, 5, "To (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(230, 1, "", 'LBR', 'C', 0, 0, '10', '', true, 0, false, true, 1, 'M');
    $pdf->Ln();
// ------------------------------ GENERAL AVERAGE ------------------------------
// ------------------------------ REMEDIAL CLASSES ------------------------------
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 5, "LEARNING AREAS", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, "FINAL RATING", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "REMEDIAL CLASS MARK", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, "RECOMPUTED FINAL GRADE", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "REMARKS", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(7);
else:
    $pdf->SetFont('helvetica', '', 6);
    $pdf->MultiCell(12, 5, "School:", 'LT', 'L', 0, 0, $x, $y, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(70, 5, '', 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(18, 5, "School ID:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '', 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "District:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, '', 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Division:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, '', 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Region:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, '', 'BTR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', '', 6);
    $pdf->MultiCell(31, 5, "Classified as Grade:", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Section:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(21, 5, "School Year:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(30, 5, "Name of Adviser/Teacher:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(39, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(18, 5, "Signature:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, "", 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(230, 2, "", 'BLR', 'L', 0, 0, '10', '', true, 0, false, true, 2, 'M');
    $pdf->Ln(3);
// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------

    $aRec = Modules::run('sf10/getAcademicRecords', $stID, $sYear, $sRec->grade_level_id);

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(90, 13, "LEARNING AREAS", '1', 'C', 0, 0, '10', '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(80, 8, "Quarterly Meeting", '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 13, "FINAL RATING", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(40, 13, "REMARKS", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(10, 8, "", '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();

    $pdf->MultiCell(90, 5, '', 'BL', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
// ------------------------------ LEARNING AREAS ------------------------------
// ------------------------------ SUBJECT 1 ------------------------------
    $pdf->SetAlpha(0.3);
    if ($i == 0):
        $pdf->Image(base_url() . 'images/forms/watermark.png', $x + 30, $y + 140, 150, 40);
    else:
        $pdf->Image(base_url() . 'images/forms/watermark.png', $x + 30, $y + 40, 150, 40);
    endif;
    for ($empty = 1; $empty < 15; $empty++):
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(90, 5, '', 'BL', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->MultiCell(20, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(40, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endfor;
    $pdf->SetAlpha(1);
    $pdf->MultiCell(230, 2, "", '1', 'C', 1, 0, '10', '', true, 0, false, true, 2, 'M');
    $pdf->Ln();

// ------------------------------ GENERAL AVERAGE ------------------------------
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(80, 5, "Remedial Classes", 'L', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "Conducted From (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(30, 5, "To (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(230, 1, "", 'LBR', 'C', 0, 0, '10', '', true, 0, false, true, 1, 'M');
    $pdf->Ln();
// ------------------------------ GENERAL AVERAGE ------------------------------
// ------------------------------ REMEDIAL CLASSES ------------------------------
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 5, "LEARNING AREAS", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, "FINAL RATING", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "REMEDIAL CLASS MARK", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, "RECOMPUTED FINAL GRADE", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "REMARKS", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(7);
endif;

// ------------------------------ REMEDIAL CLASSES ------------------------------
