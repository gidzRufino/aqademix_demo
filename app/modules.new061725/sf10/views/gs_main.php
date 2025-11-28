<?php

// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
// ------------------------------ SCHOLATIC RECORD ------------------------------

if ($i == 4):
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

if ($dbExist == 1):
    $sRec = Modules::run('sf10/getSPRrec', $stID, $sYear);

    if ($sRec->grade_level_id <= 7):
        $pdf->SetFont('helvetica', '', 6);
        $pdf->MultiCell(12, 5, "School:", 'LT', 'L', 0, 0, $x, $y, true, 0, false, true, 5, 'M');
        $pdf->MultiCell(70, 5, ($sYear == '' ? '' : strtoupper($sRec->school_name)), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "School ID:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($sYear == '' ? '' : $sRec->school_id), 'BRT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(12, 5, "District:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, ($sYear == '' ? '' : strtoupper($sRec->district)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "Division:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, ($sYear == '' ? '' : strtoupper($sRec->division)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "Region:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, ($sYear == '' ? '' : strtoupper($sRec->region)), 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetFont('helvetica', '', 6);
        $pdf->MultiCell(22, 5, "Classified as Grade:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(18, 5, ($sYear == '' ? '' : strtoupper(levelDesc($sRec->grade_level_id))), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "Section:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(18, 5, ($sYear == '' ? '' : strtoupper($sRec->section)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(21, 5, "School Year:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(18, 5, ($sYear == '' ? '' : $sYear), 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(27, 5, "Name of Adviser/Teacher:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(39, 5, ($sYear == '' ? '' : strtoupper($sRec->spr_adviser)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(18, 5, "Signature:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(28, 5, $nYear, 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(112, 2, "", 'BLR', 'L', 0, 0, $x, '', true, 0, false, true, 2, 'M');
        $pdf->Ln();
// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------

        $aRec = Modules::run('sf10/getAcademicRecords', $stID, $sYear, $sRec->grade_level_id);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(53, 13, "LEARNING AREAS", 'LBR', 'C', 0, 0, $x, '', true, 0, false, true, 13, 'M');
        $pdf->MultiCell(28, 8, "Quarterly Meeting", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        $pdf->MultiCell(12, 8, "FINAL", 'LR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(19, 13, "REMARKS", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
        $pdf->MultiCell(10, 8, "", '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->MultiCell(53, 5, '', 'BL', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, "RATING", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

// ------------------------------ LEARNING AREAS ------------------------------
// ------------------------------ SUBJECT 1 ------------------------------

        $aRec1 = 0;
        $aRec2 = 0;
        $aRec3 = 0;
        $aRec4 = 0;
        foreach ($aRec->result() as $a):
            if ($a->parent_subject == 11):
                $aRec1 += $a->first;
                $aRec2 += $a->second;
                $aRec3 += $a->third;
                $aRec4 += $a->fourth;
            endif;
        endforeach;

        $aRec1 = round($aRec1 / 4);
        $aRec2 = round($aRec2 / 4);
        $aRec3 = round($aRec3 / 4);
        $aRec4 = round($aRec4 / 4);

        $t = 0;
        $gAve = 0;
        if (count($aRec->result()) != 0 && count($aRec->result()) != 1 && $sYear != ''):
            foreach ($aRec->result() as $ar):
                if ($ar->subject_id != 18):
                    if ($ar->parent_subject == 11):
                        if ($ar->subject_id == 13):
                            $pdf->SetFont('helvetica', 'B', 7);
                            $pdf->MultiCell(53, 5, 'MAPEH', 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
                            $pdf->SetFont('helvetica', '', 7);
                            $pdf->MultiCell(7, 5, $aRec1, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $aRec2, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $aRec3, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $aRec4, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->SetFont('helvetica', '', 7);
                            $mAve = round(($aRec1 + $aRec2 + $aRec3 + $aRec4) / 4, 1);
                            $pdf->MultiCell(12, 5, $mAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(19, 5, ($mAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->Ln();

                            $pdf->SetFont('helvetica', 'I', 7);
                            $pdf->MultiCell(53, 5, '     ' . $ar->subject, 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
                            $pdf->SetFont('helvetica', '', 7);
                            $pdf->MultiCell(7, 5, $ar->first, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $ar->second, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $ar->third, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $ar->fourth, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->SetFont('helvetica', '', 7);
                            $mapehAve = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / 4, 1);
                            $pdf->MultiCell(12, 5, $mapehAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(19, 5, ($mapehAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        else:
                            $pdf->SetFont('helvetica', 'I', 7);
                            $pdf->MultiCell(53, 5, '     ' . $ar->subject, 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
                            $pdf->SetFont('helvetica', '', 7);
                            $pdf->MultiCell(7, 5, $ar->first, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $ar->second, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $ar->third, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(7, 5, $ar->fourth, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->SetFont('helvetica', '', 7);
                            $mapehAve = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / 4, 1);
                            $pdf->MultiCell(12, 5, $mapehAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                            $pdf->MultiCell(19, 5, ($mapehAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        endif;
                    else:
                        $t++;
                        $pdf->SetFont('helvetica', 'B', 7);
                        $pdf->MultiCell(53, 5, $ar->subject, 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
                        $pdf->SetFont('helvetica', '', 7);
                        $pdf->MultiCell(7, 5, $ar->first, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(7, 5, $ar->second, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(7, 5, $ar->third, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(7, 5, $ar->fourth, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->SetFont('helvetica', '', 7);
                        $aveSubj = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / 4, 1);
                        $pdf->MultiCell(12, 5, $aveSubj, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(19, 5, ($aveSubj < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $gAve += $aveSubj;
                    endif;
                    $pdf->Ln();
                endif;
            endforeach;
            if (count($aRec->result()) != 13):
                for ($emp = 0; $emp < (13 - count($aRec->result())); $emp++):
                    $pdf->SetFont('helvetica', 'I', 7);
                    $pdf->MultiCell(53, 5, '', 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 7);
                    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 7);
                    $pdf->MultiCell(12, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(19, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();
                endfor;
            endif;
        else:
            $pdf->SetAlpha(0.3);
            $pdf->Image(base_url() . 'images/forms/watermark.png', $x + 20, $y + 60, 80, 20);
            for ($empty = 1; $empty < 14; $empty++):
                $pdf->SetFont('helvetica', 'I', 7);
                $pdf->MultiCell(53, 5, '', 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 7);
                $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 7);
                $pdf->MultiCell(12, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(19, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln();
            endfor;
            $pdf->SetAlpha(1);
        endif;

// ------------------------------ SUBJECT 12 ------------------------------
// ------------------------------ GENERAL AVERAGE ------------------------------
        $genAve = round(($gAve + $mAve) / ($t + 1), 1);
        $pdf->SetFont('helvetica', 'BI', 7);
        $pdf->MultiCell(53, 5, "GENERAL AVERAGE", '1', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->MultiCell(12, 5, ($genAve != 0 ? $genAve : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(19, 5, ($genAve != 0 ? ($genAve < 75 ? 'FAILED' : 'PASSED') : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(6);
// ------------------------------ GENERAL AVERAGE ------------------------------
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "Remedial Classes", 'LTR', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "Conducted From:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(27, 5, "", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(8, 5, "To:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(27, 5, "", 'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

// ------------------------------ GENERAL AVERAGE ------------------------------
// ------------------------------ REMEDIAL CLASSES ------------------------------
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "LEARNING AREAS", 'LT', 'C', 0, 0, $x, '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(22, 5, "FINAL RATING", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(25, 5, "REMEDIAL CLASS", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(20, 5, "RECOMPUTED", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(20, 5, "REMARKS", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "", 'L', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(22, 5, "", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "MARK", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "FINAL GRADE", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", 'LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "", 'LT', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(22, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "", '1', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(22, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(7);
    else:
        $pdf->SetFont('helvetica', '', 6);
        $pdf->MultiCell(12, 5, "School:", 'LT', 'L', 0, 0, $x, $y, true, 0, false, true, 5, 'M');
        $pdf->MultiCell(70, 5, '', 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "School ID:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', 'BRT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(12, 5, "District:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "Division:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "Region:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, '', 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetFont('helvetica', '', 6);
        $pdf->MultiCell(22, 5, "Classified as Grade:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(18, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(15, 5, "Section:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(18, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(21, 5, "School Year:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(18, 5, '', 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(27, 5, "Name of Adviser/Teacher:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(39, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(18, 5, "Signature:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(28, 5, '', 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(112, 2, "", 'BLR', 'L', 0, 0, $x, '', true, 0, false, true, 2, 'M');
        $pdf->Ln();
// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(53, 13, "LEARNING AREAS", 'LBR', 'C', 0, 0, $x, '', true, 0, false, true, 13, 'M');
        $pdf->MultiCell(28, 8, "Quarterly Meeting", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        $pdf->MultiCell(12, 8, "FINAL", 'LR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(19, 13, "REMARKS", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
        $pdf->MultiCell(10, 8, "", '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->MultiCell(53, 5, '', 'BL', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, "RATING", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

// ------------------------------ LEARNING AREAS ------------------------------
// ------------------------------ SUBJECT 1 ------------------------------

        $pdf->SetAlpha(0.3);
        $pdf->Image(base_url() . 'images/forms/watermark.png', $x + 20, $y + 60, 80, 20);
        for ($empty = 1; $empty < 14; $empty++):
            $pdf->SetFont('helvetica', 'I', 7);
            $pdf->MultiCell(53, 5, '', 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', '', 7);
            $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', '', 7);
            $pdf->MultiCell(12, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(19, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endfor;
        $pdf->SetAlpha(1);

// ------------------------------ SUBJECT 12 ------------------------------
// ------------------------------ GENERAL AVERAGE ------------------------------
        $genAve = round(($gAve + $mAve) / ($t + 1), 1);
        $pdf->SetFont('helvetica', 'BI', 7);
        $pdf->MultiCell(53, 5, "GENERAL AVERAGE", '1', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->MultiCell(12, 5, ($genAve != 0 ? $genAve : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(19, 5, ($genAve != 0 ? ($genAve < 75 ? 'FAILED' : 'PASSED') : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(6);
// ------------------------------ GENERAL AVERAGE ------------------------------
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "Remedial Classes", 'LTR', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "Conducted From:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(27, 5, "", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

        $pdf->MultiCell(8, 5, "To:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(27, 5, "", 'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

// ------------------------------ GENERAL AVERAGE ------------------------------
// ------------------------------ REMEDIAL CLASSES ------------------------------
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "LEARNING AREAS", 'LT', 'C', 0, 0, $x, '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(22, 5, "FINAL RATING", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(25, 5, "REMEDIAL CLASS", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(20, 5, "RECOMPUTED", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(20, 5, "REMARKS", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "", 'L', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(22, 5, "", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "MARK", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "FINAL GRADE", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", 'LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "", 'LT', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(22, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(25, 5, "", '1', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(22, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(7);
    endif;
else:
    $pdf->SetFont('helvetica', '', 6);
    $pdf->MultiCell(12, 5, "School:", 'LT', 'L', 0, 0, $x, $y, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(70, 5, '', 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "School ID:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '', 'BRT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(12, 5, "District:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Division:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Region:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, '', 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', '', 6);
    $pdf->MultiCell(22, 5, "Classified as Grade:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(15, 5, "Section:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(21, 5, "School Year:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(18, 5, '', 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(27, 5, "Name of Adviser/Teacher:", 'L', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(39, 5, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(18, 5, "Signature:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(28, 5, '', 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(112, 2, "", 'BLR', 'L', 0, 0, $x, '', true, 0, false, true, 2, 'M');
    $pdf->Ln();
// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(53, 13, "LEARNING AREAS", 'LBR', 'C', 0, 0, $x, '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(28, 8, "Quarterly Meeting", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(12, 8, "FINAL", 'LR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(19, 13, "REMARKS", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
    $pdf->MultiCell(10, 8, "", '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();

    $pdf->MultiCell(53, 5, '', 'BL', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, "RATING", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

// ------------------------------ LEARNING AREAS ------------------------------
// ------------------------------ SUBJECT 1 ------------------------------

    $pdf->SetAlpha(0.3);
    $pdf->Image(base_url() . 'images/forms/watermark.png', $x + 20, $y + 60, 80, 20);
    for ($empty = 1; $empty < 14; $empty++):
        $pdf->SetFont('helvetica', 'I', 7);
        $pdf->MultiCell(53, 5, '', 'BL', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->MultiCell(12, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(19, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endfor;
    $pdf->SetAlpha(1);

// ------------------------------ SUBJECT 12 ------------------------------
// ------------------------------ GENERAL AVERAGE ------------------------------
    $genAve = round(($gAve + $mAve) / ($t + 1), 1);
    $pdf->SetFont('helvetica', 'BI', 7);
    $pdf->MultiCell(53, 5, "GENERAL AVERAGE", '1', 'L', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(7, 5, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->SetFont('helvetica', '', 7);
    $pdf->MultiCell(12, 5, ($genAve != 0 ? $genAve : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(19, 5, ($genAve != 0 ? ($genAve < 75 ? 'FAILED' : 'PASSED') : ''), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(6);
// ------------------------------ GENERAL AVERAGE ------------------------------
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(25, 5, "Remedial Classes", 'LTR', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, "Conducted From:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(27, 5, "", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $pdf->MultiCell(8, 5, "To:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(27, 5, "", 'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

// ------------------------------ GENERAL AVERAGE ------------------------------
// ------------------------------ REMEDIAL CLASSES ------------------------------
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(25, 5, "LEARNING AREAS", 'LT', 'C', 0, 0, $x, '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(22, 5, "FINAL RATING", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 5, "REMEDIAL CLASS", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(20, 5, "RECOMPUTED", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(20, 5, "REMARKS", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(25, 5, "", 'L', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(22, 5, "", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, "MARK", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "FINAL GRADE", 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "", 'LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(25, 5, "", 'LT', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(22, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(25, 5, "", '1', 'C', 0, 0, $x, '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(22, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(7);
endif;


//============================================================+
    // END OF FILE
    //============================================================+
