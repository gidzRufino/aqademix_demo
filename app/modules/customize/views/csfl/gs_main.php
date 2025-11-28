<?php

// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
// ------------------------------ SCHOLATIC RECORD ------------------------------

if ($i == 4 || $i == 7):
    $pdf->AddPage();
    $pdf->SetY(5);
endif;
if ($nYear > $year):
    $sYear = '';
else:
    $sYear = $nYear;
endif;
$stID = $student->sprp_st_id;
$dbExist = Modules::run('f137/checkIFdbExist', $sYear);

$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->SetXY($x, $y);
if ($dbExist == 1):
    $ov = Modules::run('f137/getObserveValues', $stID, $sYear);
    $sRec = Modules::run('f137/getSPRrec', $stID, $sYear);
    $pdf->SetFont('times', 'B', 10);
    $pdf->SetTextColor(30, 100, 90, 10);
    $pdf->MultiCell(15, 7, 'Grade ' . ($i - 1), 0, 'R', 0, 0, $x, $y, true, 0, false, true, 7, 'M');
    $pdf->SetTextColor(100, 60, 10, 5);
    $pdf->MultiCell(15, 7, '- School', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(130, 5, ($sRec->school_name != '' ? $sRec->school_name : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->SetTextColor(100, 60, 10, 5);
    $pdf->MultiCell(23, 7, 'School Year', 0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(35, 5, ($sRec->school_year != '' ? $sRec->school_year : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(7);

    $aRec = Modules::run('f137/getSPRFinalGrade', $sRec->spr_id, $sYear);
    if (count($aRec) > 0):
        $ts = count($aRec);

        $pdf->SetFont('times', 'B', 10);
        $pdf->MultiCell(85, 5, "Learning Areas", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(52, 5, "Periodic Rating", 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "Final", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(85, 5, '', 'BL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, "1", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, "2", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, "3", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, "4", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "Rating", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetFont('times', 'R', 10);

        $aRec1 = 0;
        $aRec2 = 0;
        $aRec3 = 0;
        $aRec4 = 0;
        $mt = 0;
        $t = 0;
        foreach ($aRec as $a):
            if ($a->parent_subject == 11 || $a->parent_subject == 18):
                $aRec1 += $a->first;
                $aRec2 += $a->second;
                $aRec3 += $a->third;
                $aRec4 += $a->fourth;
                $mt++;
            endif;
        endforeach;

        $aRec1 = round($aRec1 / $mt);
        $aRec2 = round($aRec2 / $mt);
        $aRec3 = round($aRec3 / $mt);
        $aRec4 = round($aRec4 / $mt);

        foreach ($aRec as $r):
            if ($r->parent_subject == 11 || $r->parent_subject == 18):
                if ($r->subject_id == 13):
                    $pdf->MultiCell(85, 5, 'MAPEH', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $aRec1, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $aRec2, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $aRec3, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $aRec4, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $mAveh = round(($aRec1 + $aRec2 + $aRec3 + $aRec4) / 4);
                    $pdf->MultiCell(20, 5, $mAveh, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();

                    $pdf->MultiCell(85, 5, '        ' . $r->subject, 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->first, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->second, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->third, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->fourth, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $mapeh = round(($r->first + $r->second + $r->third + $r->fourth) / 4);
                    $pdf->MultiCell(20, 5, $mapeh, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                else:
                    $pdf->MultiCell(85, 5, '        ' . $r->subject, 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->first, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->second, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->third, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(13, 5, $r->fourth, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $mapeh = round(($r->first + $r->second + $r->third + $r->fourth) / 4);
                    $pdf->MultiCell(20, 5, $mapeh, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                endif;
            else:
                $t++;
                $pdf->MultiCell(85, 5, $r->subject, 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(13, 5, $r->first, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(13, 5, $r->second, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(13, 5, $r->third, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(13, 5, $r->fourth, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $aveSubj = round(($r->first + $r->second + $r->third + $r->fourth) / 4);
                $pdf->MultiCell(20, 5, $aveSubj, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                $first += $r->first;
                $second += $r->second;
                $third += $r->third;
                $fourth += $r->fourth;
            endif;

            $pdf->Ln();
        endforeach;

        $firstAve = round(($first + $aRec1) / ($t + 1));
        $secondAve = round(($second + $aRec1) / ($t + 1));
        $thirdAve = round(($third + $aRec1) / ($t + 1));
        $fourthAve = round(($fourth + $aRec1) / ($t + 1));

        $pdf->SetFont('times', 'B', 10);
        $pdf->MultiCell(85, 5, 'Average', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, $firstAve, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, $secondAve, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, $thirdAve, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, $fourthAve, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $finalAve = round(($firstAve + $secondAve + $thirdAve + $fourthAve) / 4);
        $pdf->MultiCell(20, 5, $finalAve, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(15);
    else:
        $ts = 13;
        emptyRec($pdf, $i, $x, $y);
        $pdf->Ln(15);
    endif;
else:
    $ts = 13;
    emptyRec($pdf, $i, $x, $y);
    $pdf->Ln(15);
endif;


$pdf->SetXY($abx, $aby);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(45, 7, 'Grading System:', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->MultiCell(85, 7, '90 - 100           Outstanding (O)', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, '85 - 89            Very Satisfactory (VS)', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, '80 - 84            Satisfactory (S)', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, '75 - 79            Fairly Satisfactory (FS)', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, '74 & below     Did Not Meet', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, '                       Expectations (Failed)', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetX($abx);
$pdf->MultiCell(45, 7, 'Observed Values:', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->MultiCell(85, 7, 'Maka-Dios       -       ' . Modules::run('f137/observeValues', $ov->maka_dios), 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, 'Makatao         -       ' . Modules::run('f137/observeValues', $ov->maka_tao), 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, 'Makakalikasan   -       ' . Modules::run('f137/observeValues', $ov->maka_kalikasan), 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetX($abx);
$pdf->MultiCell(85, 7, 'Makabansa       -       ' . Modules::run('f137/observeValues', $ov->maka_bansa), 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);



//-------------------------------------------- FRAMES --------------------------------------------------------------------

$pdf->SetLineStyle(array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255)));
$pdf->RoundedRect(10, $rectA, 230, (7 + ((($ts + 1) * 5) + 20) + 2), 0, '0000', '');

$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255)));
$pdf->RoundedRect(11, $rectB, 228, (5 + ((($ts + 1) * 5) + 20) + 2), 0, '0000', '');

//============================================================+
    // END OF FILE
    //============================================================+
