<?php

switch (segment_5) {
    case 1:
    case 2:
        $shs = 1;
        $sem = 1;
        $term = 'First';
        $one = '1st';
        $two = '2nd';
        $semNum = '1st';
        break;
    case 3:
    case 4:
        $shs = 3;
        $sem = 2;
        $term = 'Second';
        $one = '3rd';
        $two = '4th';
        $semNum = '2nd';
        break;
}

$settings = Modules::run('main/getSet');

$image_file = K_PATH_IMAGES . '/pisd.png';
$pdf->Image($image_file, $x + 35, $y + 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('times', 'B', 12);
$pdf->MultiCell(15, 5, '', '', 'R', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetTextColor(191, 121, 0);
$pdf->setXY($x + 50, $y + 5);
$pdf->MultiCell(120, 2, 'PRECIOUS INTERNATIONAL SCHOOL OF DAVAO', '', 'C', 0, 0, '', '', true);

$pdf->SetFont('times', 'N', 8);
$pdf->Ln(4);

$pdf->setXY($x + 50, $y + 9);
$pdf->SetTextColor(0, 0, 0, 100);
$pdf->MultiCell(120, 2, 'Cor. Santos Cuyugan - Maple Street, GSIS Heights, Matina, Davao City, Philippines', '', 'C', 0, 0, '', '', true);

$pdf->SetFont('times', 'N', 8);
$pdf->Ln(0);
$pdf->MultiCell(25, 5, '', '', 'R', 0, 0, '', '', true);
$pdf->Ln(3);

$pdf->setXY($x + 50, $y + 12);
$pdf->SetTextColor(0, 0, 0, 100);
$pdf->MultiCell(120, 2, 'SHS Provisional Permit R-XI No. 20 s.2015', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->setXY($x + 50, $y + 17);
$pdf->SetFont('times', 'B', 10);
$pdf->SetTextColor(0, 0, 0, 100);
$pdf->MultiCell(120, 2, 'OFFICIAL REPORT CARD', '', 'C', 0, 0, '', '', true);
$pdf->setXY($x + 50, $y + 21);
$pdf->SetFont('times', 'R', 9);
$pdf->SetTextColor(0, 0, 0, 100);
$pdf->MultiCell(120, 2, 'SENIOR HIGH SCHOOL DEPARTMENT', '', 'C', 0, 0, '', '', true);
$pdf->Ln(3);

$pdf->setXY($x + 5, $y + 26);
$pdf->SetFont('times', 'R', 8);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(15, 5, 'NAME:', '', 'L', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(45, 5, strtoupper($mStudent->lastname . ', ' . $mStudent->firstname . ' ' . substr($mStudent->middlename, 0, 1)), '', 'L', 1, 0, '', '', true);

$from = new DateTime($mStudent->bdate_id);
$to   = new DateTime('today');
$yearsOfAge = $from->diff($to)->y;

$pdf->SetFont('times', 'R', 8);
$pdf->Cell(20, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(5, 5, 'AGE:', '', 'L', 0, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20, 5, $yearsOfAge, '', 'L', 1, 0, '', '', true);

$pdf->SetFont('times', 'R', 8);
$pdf->Cell(25, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(25, 5, 'YEAR & SECTION:', '', 'L', 0, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(40, 5, $section->level . ' - ' . $section->section . ' - ' . $shStrand->short_code, '', 'L', 1, 0, '', '', true);
$pdf->Ln();

$pdf->setXY($x + 5, $y + 30);
$pdf->SetFont('times', 'R', 8);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(15, 5, 'TEACHER:', '', 'L', 0, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->Cell(1, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(65, 5, strtoupper($adviser->lastname . ', ' . $adviser->firstname . ' ' . substr($adviser->middlename, 0, 1)), '', 'L', 1, 0, '', '', true);

$pdf->SetFont('times', 'R', 8);
$pdf->Cell(3, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(5, 5, 'SEMESTER:', '', 'L', 0, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->Cell(5, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(25, 5, $term, '', 'R', 1, 0, '', '', true);

$pdf->SetFont('times', 'R', 8);
$pdf->Cell(15, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(25, 5, 'ACADEMIC YEAR:', '', 'L', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(34, 5, $sy . ' - ' . $nxtYr, '', 'L', 1, 0, '', '', true);
$pdf->Ln();

//$pdf->setXY($x + 5, $y + 22);
$pdf->SetFont('times', 'R', 8);
$pdf->SetTextColor(100, 0, 0, 0);
$pdf->Cell(7, 5, 'LRN:', '', 'C', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(72, 5, $mStudent->lrn, '', 'L', 1, 0, '', '', true);
$pdf->Ln();


// THIS IS THE LEFT SIDE
//$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->SetX($x + 2);
$pdf->MultiCell(44, 10, 'LEARNING AREAS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(22, 5, 'Quarter', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(20, 10, $semNum . ' Sem. Final Grade', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Descriptor', 'T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'and Grading', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Outstanding', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'R', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, '(90-100)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Very', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Satisfactory', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'R', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, '(85-89)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Satisfactory', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'R', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, '(80-84)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Fairly', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Satisfactory)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'R', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, '(75-79)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Did Not', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Meet', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'B', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, 'Expectation', 'L', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetFont('times', 'R', 8);
$pdf->SetX($x + 88);
$pdf->MultiCell(20, 3, '(Below 75)', 'L,B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();

$pdf->Ln();
$pdf->SetXY($x + 46, $y + 45);
$pdf->MultiCell(11, 5, $one, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, $two, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFillColor(200, 218, 247);
$pdf->SetFont('times', 'B', 8);
$pdf->Ln();
$pdf->SetX($x + 2);
$pdf->MultiCell(86, 5, 'Core Subjects', 1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
$mp = 0;
$m = 0;

$fontSize = 8;
$tempFontSize = $fontSize;
foreach ($coreSubs as $sub):

    $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
    $firstGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $shs, $sy);
    $secondGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $shs + 1, $sy);
    $pdf->Ln();
    $pdf->SetX($x + 2);
    if ($sub->is_core):
        $mp++;
        $pdf->SetFont('times', 'R', 7);
        $cellWidth = 44;
        while ($pdf->GetStringWidth($sub->subject) > $cellWidth) {
            $pdf->SetFontSize($tempFontSize -= 0.5);
        }

        $pdf->MultiCell(44, 5, $sub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //$tempFontSize = $fontSize;
        $pdf->SetFontSize($fontSize);
    endif;
    if ($sub->is_core):
        if ($firstGrade->row()->final_rating != ""):
            $pdf->MultiCell(11, 5, ($firstGrade->row()->final_rating == '' ? '' : $firstGrade->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(11, 5, ($secondGrade->row()->final_rating == '' ? '' : $secondGrade->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            if (segment_5 == 2 || segment_5 == 4):
                $pdf->MultiCell(20, 5, round(($firstGrade->row()->final_rating + $secondGrade->row()->final_rating) / 2, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            else:
                $pdf->MultiCell(20, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            endif;
            $coreTotal += round(($firstGrade->row()->final_rating + $secondGrade->row()->final_rating) / 2, 2);
        else:
            $pdf->MultiCell(11, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(11, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            $pdf->MultiCell(20, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        endif;
    endif;

endforeach;
$pdf->Ln();
$pdf->SetX($x + 2);
$pdf->SetFont('times', 'b', 8);
$pdf->MultiCell(86, 5, 'Applied and Specialized Subjects', 1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');

foreach ($appliedSubs as $sub):
    $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
    $firstGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $shs, $sy);
    $secondGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $shs + 1, $sy);
    $pdf->Ln();
    $pdf->SetX($x + 2);
    $pdf->SetFont('times', 'R', 7);
    $cellWidth = 44;
    while ($pdf->GetStringWidth($sub->subject) > $cellWidth) {
        $pdf->SetFontSize($tempFontSize -= 0.5);
    }
    $pdf->MultiCell(44, 5, $sub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $tempFontSize = $fontSize;
    $pdf->SetFontSize($fontSize);
    $mp++;
    if ($firstGrade->row()->final_rating != ""):
        $pdf->MultiCell(11, 5, ($firstGrade->row()->final_rating == '' ? '' : $firstGrade->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, ($secondGrade->row()->final_rating == '' ? '' : $secondGrade->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        if (segment_5 == 2 || segment_5 == 4):
            $pdf->MultiCell(20, 5, round(($firstGrade->row()->final_rating + $secondGrade->row()->final_rating) / 2, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        else:
            $pdf->MultiCell(20, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        endif;
        $appliedTotal += round(($firstGrade->row()->final_rating + $secondGrade->row()->final_rating) / 2, 2);
    else:
        $pdf->MultiCell(11, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(11, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    endif;


endforeach;
$genTotal = $coreTotal + $appliedTotal;
$genAve = round($genTotal / $mp, 2);
$pdf->Ln();
$pdf->SetX($x + 2);
$pdf->SetFont('times', 'b', 8);
$pdf->MultiCell(66, 5, 'General Average for the Semester', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
if (segment_5 == 2 || segment_5 == 4):
    $pdf->MultiCell(20, 5, ($genAve == 0 ? '' : $genAve), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
else:
    $pdf->MultiCell(20, 5, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
endif;
$pdf->Ln();
//attendance Record

$pdf->SetX($x + 2);
$pdf->MultiCell(98, 10, 'ATTENDANCE RECORD', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX($x + 2);
$pdf->MultiCell(23, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
$pdf->MultiCell(15, 5, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->SetX($x + 2);
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(23, 5, 'Days of School', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


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
$pdf->MultiCell(15, 5, '201', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX($x + 2);
$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(200, 218, 247);
$pdf->MultiCell(23, 5, 'Days Present', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $mStudent->st_id, $grade_id, $this->session->school_year);
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->July > 16 ? '16' : $attendance->July) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->August > 23 ? '23' : $attendance->August) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->September > 21 ? '21' : $attendance->September) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->October > 23 ? '23' : $attendance->October) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->November > 22 ? '22' : $attendance->November) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->December > 15 ? '15' : $attendance->December) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->January > 18 ? '18' : $attendance->January) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->February > 20 ? '20' : $attendance->February) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->March > 21 ? '21' : $attendance->March) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, ($attendance ? ($attendance->April > 22 ? '22' : $attendance->April) : 0), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$totalDaysPresent = ($attendance ? ($attendance->July > 16 ? '16' : $attendance->July) + ($attendance->August > 23 ? '23' : $attendance->August) + ($attendance->September > 21 ? '21' : $attendance->September) + $attendance->October + $attendance->November + $attendance->December + $attendance->January + $attendance->February + $attendance->March + $attendance->April : 0);
$pdf->MultiCell(15, 5, $totalDaysPresent, 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX($x + 2);
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(23, 5, 'Days Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
$totalDaysTardy = $tardyJul->num_rows() + $tardyAug->num_rows() + $tardySept->num_rows() + $tardyOct->num_rows() + $tardyNov->num_rows() + $tardyDec->num_rows() + $tardyJan->num_rows() + $tardyFeb->num_rows() + $tardyMar->num_rows() + $tardyApr->num_rows();
$pdf->MultiCell(15, 5, $totalDaysTardy, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

//deportment

$pdf->SetXY($x + 107, $y + 40);
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(33, 10, 'DEPORTMENT', '1', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(30, 10, 'Grade', '1', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$deportment = Modules::run('academic/getBHRate');
$w = 1;
foreach ($deportment as $dept):
    $pdf->SetFont('times', 'R', 7);
    $pdf->SetFillColor(200, 218, 247);
    if ($dept->bh_group == 1) {
        $pdf->SetX($x + 107);
        $pdf->MultiCell(33, 5, $dept->bh_name, '1', 'L', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $sh = $shs;
        for ($why = 0; $why < 2; $why++) {
            $finalDeport = Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $mStudent->st_id, $dept->bh_id, $sh, $sy);
            $transmutedBh = Modules::run('gradingsystem/gradingsystem_reports/bhTransmutted', $finalDeport->rate);

            $pdf->SetFont('times', 'R', 7);
            if ($finalDeport->rate != '') {
                $pdf->MultiCell(15, 5, $transmutedBh, '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            } else {
                $pdf->MultiCell(15, 5, '', '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
            }
            $sh++;
        }
        $pdf->Ln();
    } elseif ($dept->bh_group == 2) {
        $pdf->SetX($x + 107);
        $pdf->MultiCell(33, 5, $dept->bh_name, '1', 'L', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', '1', 'C', (($w % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $sub = Modules::run('reports/getSubBH', 3);
        $a = 1;
        foreach ($sub as $bus):
            $pdf->SetFont('times', 'R', 7);
            $pdf->SetFillColor(200, 218, 247);
            $pdf->SetX($x + 107);
            $pdf->MultiCell(33, 5, '  ' . $bus->bh_name, '1', 'L', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $sh2 = $shs;
            for ($why = 0; $why < 2; $why++) {
                $finalDeport2 = Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $mStudent->st_id, $bus->bh_id, $sh2, $sy);
                $transmutedBh2 = Modules::run('gradingsystem/gradingsystem_reports/bhTransmutted', $finalDeport2->rate);
                if ($finalDeport2->rate != '') {
                    $pdf->MultiCell(15, 5, $transmutedBh2, '1', 'C', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
                } else {
                    $pdf->MultiCell(15, 5, '', '1', 'C', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
                }
                $sh2++;
            }
            //$pdf->MultiCell(15, 5, '', '1', 'C', (($a % 2) == 0 ? 1 : 0), 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $a++;
        endforeach;
    }
    $w++;
endforeach;
$pdf->SetXY($x + 170, $y + 40);
$pdf->MultiCell(35, 5, '', 'T,L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, 'Evaluation Code:', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' A +   =    100  ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' A     =  98 - 99 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' A -   =  95 - 97 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' B +   =  92 - 94 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' B     =  89 - 91 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' B -   =  86 - 88 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' C +   =  83 - 85 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' C     =  80 - 82 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' C -   =  77 - 79 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' D +   =  75 - 76 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' D     =  72 - 74 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, ' D -   =  70 - 71 ', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 5, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX($x + 170);
$pdf->MultiCell(35, 7, '', 'B,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->setXY($x + 100, $y + 115);
$pdf->SetFont('times', 'R', 7);
$pdf->MultiCell(105, 3, '', 'T,L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(2);
$pdf->SetX($x + 100);
$pdf->MultiCell(105, 3, 'The grading system used is averaging where the grades obtained for each grading period', 'L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);
$pdf->SetX($x + 100);
$pdf->MultiCell(105, 3, 'are independent from that of the other grading periods. For academic learning areas,', 'L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);
$pdf->SetX($x + 100);
$pdf->MultiCell(105, 3, 'numerical marks are used with their corresponding descriptors while letter grades are', 'L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);
$pdf->SetX($x + 100);
$pdf->MultiCell(105, 3, 'used in deportment. The passing mark for academic subjects is 75%. Any grade below is', 'L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);
$pdf->SetX($x + 100);
$pdf->MultiCell(105, 3, 'a failure', 'L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(2);
$pdf->SetX($x + 100);
$pdf->MultiCell(105, 2, '', 'B,L,R', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);
$pdf->SetX($x + 100);
$pdf->SetFont('times', 'I', 7);
$pdf->MultiCell(105, 2, 'This is a computer-generated form. Signature is not necessary.', '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');




unset($mp);
unset($coreTotal);
unset($appliedTotal);
$x = $x + 107;


$pdf->SetXY($x + 1, $y + 40);

