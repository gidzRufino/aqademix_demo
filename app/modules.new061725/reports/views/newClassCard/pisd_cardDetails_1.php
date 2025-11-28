<?php
ob_start();
$image_file = K_PATH_IMAGES . '/pisd.png';
$pdf->Image($image_file, $x, $y + 2, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('times', 'B', 9);
$pdf->MultiCell(15, 5, '', '', 'R', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetTextColor(191, 121, 0);
$pdf->setXY($x + 15, $y + 5);
$pdf->MultiCell(120, 2, 'PRECIOUS INTERNATIONAL SCHOOL OF DAVAO', '', 'L', 0, 0, '', '', true);
$pdf->SetTextColor(0, 0, 0, 100);
$pdf->MultiCell(95, 7, ' OFFICIAL REPORT CARD', 'L', 'L', 0, 0, '', '', true);

$pdf->SetFont('times', 'N', 8);
$pdf->Ln(4);

$pdf->setXY($x + 15, $y + 8);
$pdf->MultiCell(120, 2, 'Cor. Santos Cuyugan - Maple Street, GSIS Heights, Matina, Davao City, Philippines', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(95, 5, ' K-to-12', 'L', 'L', 0, 0, '', '', true);

$pdf->SetFont('times', 'N', 8);
$pdf->Ln(0);
$pdf->MultiCell(25, 5, '', '', 'R', 0, 0, '', '', true);
$pdf->Ln(3);

$pdf->setXY($x + 15, $y + 11);
$pdf->MultiCell(120, 2, 'Government Recognition (R-XI) No. 05 S. 2012', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('times', 'B', 13);
$pdf->MultiCell(95, 5, ' ', 'L', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->setXY($x + 5, $y + 16);
$pdf->SetFont('helvetica', 'R', 7);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(10, 5, 'NAME:', '', 'L', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 7);
$pdf->Cell(60, 5, strtoupper($mStudent->lastname . ', ' . $mStudent->firstname . ' ' . substr($mStudent->middlename, 0, 1)), '', 'L', 1, 0, '', '', true);

$pdf->SetFont('times', 'R', 7);
$pdf->Cell(30, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(15, 5, 'LEVEL:', '', 'L', 0, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(90, 5, $section->level . ' - ' . $section->section, '', 'L', 1, 0, '', '', true);
$pdf->Ln();

$pdf->setXY($x + 5, $y + 19);
$pdf->SetFont('times', 'R', 7);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(23, 5, 'ACADEMIC YEAR:', '', 'L', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(34, 5, $sy . ' - ' . $nxtYr, '', 'L', 1, 0, '', '', true);

$pdf->SetFont('times', 'R', 7);
$pdf->Cell(40, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(18, 5, 'TEACHER:', '', 'L', 0, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(90, 5, strtoupper($adviser->lastname . ', ' . $adviser->firstname . ' ' . substr($adviser->middlename, 0, 1)), '', 'L', 1, 0, '', '', true);
$pdf->Ln();

$pdf->setXY($x + 5, $y + 22);
$pdf->SetFont('times', 'R', 7);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(16, 5, '', '', 'C', 1, 0, '', '', true);
$pdf->Cell(7, 5, 'LRN:', '', 'C', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(72, 5, $mStudent->lrn, '', 'L', 1, 0, '', '', true);
$pdf->Ln();


// THIS IS THE LEFT SIDE

$pdf->setX($x + 5);
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(45, 10, 'LEARNING AREAS', '1', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(24, 5, 'QUARTER', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(13, 10, 'FINAL GRADE', '1', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, 'Remarks', '1', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetXY($x + 50, $y + 32);
$pdf->MultiCell(6, 5, '1st', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '2nd', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '3rd', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '4th', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$grd = 0;
$mp = 0;

foreach ($subject_ids as $sp):
    $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
    $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, segment_5, $sy);
    if ($singleSub->parent_subject == 11):
        $grd += $finalGrade->row()->final_rating;
        $mp += 1;
    endif;
endforeach;
$fg = round($grd / $mp);
unset($grd);

$m = 0;
$z = 0;
$fontSize = 7;
$tempFontSize = $fontSize;
foreach ($subject_ids as $sub):
    $z++;
    $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
    if ($singleSub->parent_subject != 11):
        $pdf->setX($x + 5);
        $pdf->SetFont('times', 'R', 7);
        $pdf->SetFillColor(200, 218, 247);
        $cellWidth = 45;
        while ($pdf->GetStringWidth($singleSub->subject) > $cellWidth) {
            $pdf->SetFontSize($tempFontSize -= 0.1);
        }
        $pdf->MultiCell($cellWidth, 5, $singleSub->subject, 1, 'L', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $tempFontSize = $fontSize;
        $pdf->SetFontSize($fontSize);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, 1, $sy);
        $pdf->MultiCell(6, 5, ($finalGrade->row()->final_rating != 0 ? $finalGrade->row()->final_rating : ''), '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, ($finalGrade->row()->final_rating >= 75 ? 'PASSED' : 'FAILED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    else:
        $m++;
        if ($m == 1):
            $z++;
            $pdf->MultiCell(45, 5, 'MAPEH', 1, 'L', (($z % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, ($fg == 0 ? '' : $fg), '1', 'C', (($z % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(13, 5, '', '1', 'C', (($z % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, ($fg >= 75 ? 'PASSED' : 'FAILED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $pdf->setX($x + 5);
            $pdf->MultiCell(45, 5, '       ' . $singleSub->subject, 1, 'L', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, 1, $sy);
            $pdf->MultiCell(6, 5, ($finalGrade->row()->final_rating != 0 ? $finalGrade->row()->final_rating : ''), '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(13, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, ($finalGrade->row()->final_rating >= 75 ? 'PASSED' : 'FAILED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        else:
            $pdf->setX($x + 5);
            $pdf->MultiCell(45, 5, '       ' . $singleSub->subject, 1, 'L', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, 1, $sy);
            $pdf->MultiCell(6, 5, ($finalGrade->row()->final_rating != 0 ? $finalGrade->row()->final_rating : ''), '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(6, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(13, 5, '', '1', 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, ($finalGrade->row()->final_rating >= 75 ? 'PASSED' : 'FAILED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endif;
    endif;



endforeach;

$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(53, 5, 'Descriptors', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Grading Scale', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Remarks', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(53, 5, 'Outstanding', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '90 - 100', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(53, 5, 'Very Satisfactory', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '85 - 89', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->MultiCell(53, 5, 'Satisfactory', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '80 - 84', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->MultiCell(53, 5, 'Fairly Satisfactory', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '75 - 79', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->MultiCell(53, 5, 'Did not meet the Expectations', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Below 75', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Failed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(28, 4, 'Eligible for Admission to', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(50, 4, '', 'B', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(24, 4, 'Has advanced units in', '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(45, 4, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(3, 5, ',', '', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(15, 4, 'lacks units in', '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 11);
$pdf->MultiCell(30, 4, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(40, 4, 'PERLA P. KWAN', 'B', 'C', 0, 0, '140', '', true, 0, false, true, 4, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(85, 4, 'CANCELLATION OF TRANSFER ELIGIBILITY:', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(40, 4, 'SCHOOL PRINCIPAL', '', 'C', 0, 0, '140', '', true, 0, false, true, 4, 'B');
$pdf->Ln();

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(23, 4, 'Has been admitted to', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(50, 4, '', 'B', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(7, 4, 'year', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(40, 4, '', 'B', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(10, 4, 'school.', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(15);



// THIS IS THE RIGHT SIDE


$pdf->SetXY($x + 109, $y + 27);
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(35, 6.2, 'DEPORTMENT', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(8, 6.2, '1st', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 6.2, '2nd', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 6.2, '3rd', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 6.2, '4th', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$deportment = Modules::run('academic/getBHRate');
$w = 1;
foreach ($deportment as $dept):
    $pdf->SetFont('times', 'R', 7);
    $pdf->SetFillColor(200, 218, 247);
    if ($dept->bh_group == 1) {
        $pdf->SetX($x + 109);
        $pdf->MultiCell(35, 5, $dept->bh_name, '1', 'L', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        for ($why = 0; $why < 4; $why++) {
            $finalDeport = Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $mStudent->st_id, $dept->bh_id, $why + 1, $sy);
            $transmutedBh = Modules::run('gradingsystem/gradingsystem_reports/bhTransmutted', $finalDeport->rate);

            $pdf->SetFont('times', 'R', 7);

            $pdf->MultiCell(8, 5, $transmutedBh, '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        }
        $pdf->Ln();
    } elseif ($dept->bh_group == 2) {
        $pdf->SetX($x + 109);
        $pdf->MultiCell(35, 5, $dept->bh_name, '1', 'L', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(8, 5, '', '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(8, 5, '', '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(8, 5, '', '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(8, 5, '', '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $sub = Modules::run('reports/getSubBH', 3);
        $a = 1;
        foreach ($sub as $bus):
            $finalDeport2 = Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $mStudent->st_id, $bus->bh_id, $term, $sy);
            $transmutedBh2 = Modules::run('gradingsystem/gradingsystem_reports/bhTransmutted', $finalDeport2->rate);
            $pdf->SetFont('times', 'I', 7);
            $pdf->SetFillColor(200, 218, 247);
            $pdf->SetX($x + 109);
            $pdf->MultiCell(35, 5, '  ' . $bus->bh_name, '1', 'L', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(8, 5, $transmutedBh2, '1', 'C', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(8, 5, '', '1', 'C', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(8, 5, '', '1', 'C', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(8, 5, '', '1', 'C', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $a++;
        endforeach;
    }
    $w++;
endforeach;
$pdf->SetXY($x + 170, $y + 27);
$pdf->MultiCell(45, 5, 'LEGEND', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, '(Non-Academic / Deportment)', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' A +   =    100  ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' A     =  98 - 99 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' A -   =  95 - 97 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' B +   =  92 - 94 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' B     =  89 - 91 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' B -   =  86 - 88 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' C +   =  83 - 85 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' C     =  80 - 82 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' C -   =  77 - 79 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' D +   =  75 - 76 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' D     =  72 - 74 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(45, 5, ' D -   =  70 - 71 ', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetXY($x + 109, $y + 100);
$pdf->MultiCell(19, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'R', 6);
$pdf->MultiCell(6, 5, 'Jul', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Aug', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Sept', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Oct', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Nov', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Dec', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Jan', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Feb', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Mar', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Apr', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->SetX($x + 109);
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(19, 5, 'Days of School', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

//$pdf->SetFont('times', 'B', 6);
//$sd = Modules::run('reports/getRawSchoolDays', $sy);
//$pdf->MultiCell(6, 5, $sd->row()->July, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->August, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->September, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->October, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->November, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->December, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->January, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->February, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->March, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(6, 5, $sd->row()->April, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$totalDays = $sd->row()->July + $sd->row()->August + $sd->row()->September + $sd->row()->October + $sd->row()->November + $sd->row()->December + $sd->row()->January + $sd->row()->February + $sd->row()->March + $sd->row()->April;
//$pdf->MultiCell(10, 5, $totalDays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->Ln();

$pdf->SetFont('times', 'B', 6);
$sd = Modules::run('reports/getRawSchoolDays', $sy);
$pdf->MultiCell(6, 5, '16', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '23', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '21', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '23', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '22', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '15', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '18', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '20', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '21', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, '22', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$totalDays = $sd->row()->July + $sd->row()->August + $sd->row()->September + $sd->row()->October + $sd->row()->November + $sd->row()->December + $sd->row()->January + $sd->row()->February + $sd->row()->March + $sd->row()->April;
$pdf->MultiCell(10, 5, '201', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX($x + 109);
$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(200, 218, 247);
$pdf->MultiCell(19, 5, 'Days Present', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $mStudent->st_id, $grade_id, $this->session->school_year);
$year = $sy;
$holiday = Modules::run('calendar/holidayExist', 7);
$theMonth = $attendance->July + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 8);
$theMonth = $attendance->August + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 9);
$theMonth = $attendance->September + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 10);
$theMonth = $attendance->October + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 11);
$theMonth = $attendance->November + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 12);
$theMonth = $attendance->December + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 1);
$theMonth = $attendance->January + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 2);
$theMonth = $attendance->February + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 3);
$theMonth = $attendance->March + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$holiday = Modules::run('calendar/holidayExist', 4);
$theMonth = $attendance->April + $holiday->num_rows();
$pdf->MultiCell(6, 5, ($attendance ? $theMonth : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$totalDaysPresent = ($attendance ? $attendance->July + $attendance->August + $attendance->September + $attendance->October + $attendance->November + $attendance->December + $attendance->January + $attendance->February + $attendance->March + $attendance->April : 0);
$pdf->MultiCell(10, 5, $totalDaysPresent, 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX($x + 109);
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(19, 5, 'Days Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$tardyJul = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 7, $this->session->school_year);
$tardyAug = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 8, $this->session->school_year);
$tardySept = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 9, $this->session->school_year);
$tardyOct = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 10, $this->session->school_year);
$tardyNov = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 11, $this->session->school_year);
$tardyDec = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 12, $this->session->school_year);
$tardyJan = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 1, $this->session->school_year);
$tardyFeb = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 2, $this->session->school_year);
$tardyMar = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 3, $this->session->school_year);
$tardyApr = Modules::run('attendance/attendance_reports/getTotalTardyPerStudent', $mStudent->st_id, 4, $this->session->school_year);
$pdf->MultiCell(6, 5, $tardyJul->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyAug->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardySept->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyOct->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyNov->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyDec->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyJan->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyFeb->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyMar->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $tardyApr->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$totalDaysTardy = $tardyJul->num_rows() + $tardyAug->num_rows() + $tardySept->num_rows() + $tardyOct->num_rows() + $tardyNov->num_rows() + $tardyNov->num_rows() + $tardyJan->num_rows() + $tardyFeb->num_rows() + $tardyMar->num_rows() + $tardyApr->num_rows();
$pdf->MultiCell(10, 5, $totalDaysTardy, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
