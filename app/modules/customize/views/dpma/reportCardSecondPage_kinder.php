<?php

function GetMultiCellHeight($w, $txt, $pdf) {
    $height = 5;
    $strlen = strlen($txt);
    $wdth = 0;
    for ($i = 0; $i <= $strlen; $i++) {
        $char = substr($txt, $i, 1);
        $wdth += $pdf->GetStringWidth($char);
        if ($char == "\n") {
            $height++;
            $wdth = 0;
        }
        if ($wdth >= $w) {
            $height++;
            $wdth = 0;
        }
    }
    return $height;
}

$pdf->Line(99, 5, 99, 1, array('color' => 'black'));
$pdf->Line(198, 5, 198, 1, array('color' => 'black'));

//----------------------------------- start left side --------------------------------------- //

$pdf->SetXY(5, 5);
$pdf->SetFillColor(219, 229, 241);
//$pdf->SetFillColor(242, 219, 219);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(58, 10, 'Language, Literacy and Communication', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(32, 10, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFillColor(242, 219, 219);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(58, 10, 'Listening and Viewing', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q1', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q2', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q3', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q4', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 1);
$pdf->SetFont('helvetica', 'R', 7);
$line_height = 5;
$width = 58;
foreach ($subj_details as $sd):
    $first = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 1, $sy);
    $second = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 2, $sy);
    $third = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 3, $sy);
    $fourth = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 4, $sy);

    $pdf->SetX(5);
    $height = GetMultiCellHeight($width, $sd->details, $pdf);
    $pdf->MultiCell($width, 1.8 * $height, $sd->details, 1, 'L', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $first->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $second->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $third->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $fourth->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->Ln();
endforeach;

$pdf->SetX(5);
$pdf->SetFillColor(242, 219, 219);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(58, 10, 'Speaking', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q1', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q2', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q3', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 10, 'Q4', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 2);
$pdf->SetFont('helvetica', 'R', 7);
foreach ($subj_details as $sd):
    $first = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 1, $sy);
    $second = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 2, $sy);
    $third = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 3, $sy);
    $fourth = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 4, $sy);

    $pdf->SetX(5);
    $height = GetMultiCellHeight($width, $sd->details, $pdf);
    $pdf->MultiCell($width, 1.8 * $height, $sd->details, 1, 'L', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $first->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $second->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $third->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->MultiCell(8, 1.8 * $height, $fourth->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.8 * $height, 'M');
    $pdf->Ln();
endforeach;

//---------------------------------------- end left side --------------------------------------------------------------------//
//---------------------------------------- start of center page -------------------------------------------------------------//

$pdf->SetXY(103, 5);
$pdf->SetFillColor(242, 219, 219);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(58, 7, 'Reading', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q1', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q2', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q3', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q4', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 3);
$pdf->SetFont('helvetica', 'R', 7);
foreach ($subj_details as $sd):
    $first = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 1, $sy);
    $second = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 2, $sy);
    $third = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 3, $sy);
    $fourth = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 4, $sy);

    $pdf->SetX(103);
    $height = GetMultiCellHeight($width, $sd->details, $pdf);
    $pdf->MultiCell($width, 2 * $height, $sd->details, 1, 'L', 0, 0, '', '', true, 0, false, true, 2 * $height, 'M');
    $pdf->MultiCell(8, 2 * $height, $first->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 2 * $height, 'M');
    $pdf->MultiCell(8, 2 * $height, $second->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 2 * $height, 'M');
    $pdf->MultiCell(8, 2 * $height, $third->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 2 * $height, 'M');
    $pdf->MultiCell(8, 2 * $height, $fourth->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 2 * $height, 'M');
    $pdf->Ln();
endforeach;

$pdf->SetX(103);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(58, 7, 'Writing', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q1', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q2', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q3', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q4', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 4);
$pdf->SetFont('helvetica', 'R', 7);
foreach ($subj_details as $sd):
    $first = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 1, $sy);
    $second = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 2, $sy);
    $third = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 3, $sy);
    $fourth = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 4, $sy);

    $pdf->SetX(103);
    $height = GetMultiCellHeight($width, $sd->details, $pdf);
    $pdf->MultiCell($width, 1.5 * $height, $sd->details, 1, 'L', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $first->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $second->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $third->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $fourth->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->Ln();
endforeach;

$pdf->SetX(99);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(99, 5, 'Legend:', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(99);
$pdf->MultiCell(99, 5, 'RATING INDICATORS', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(103);
$pdf->MultiCell(20, 13.5, 'Beginning (B)', 1, 'C', 0, 0, '', '', true, 0, false, true, 13.5, 'M');
$pdf->SetFont('helvetica', 'R', 6);
$pdf->writeHTMLCell(73, 4, '', $pdf->SetX(120), '<ul><li>Struggles with understanding</li></ul>', 'TR', 0, 0, true, 'L', true);
$pdf->Ln();

$pdf->writeHTMLCell(73, 4, '', $pdf->SetX(120), '<ul><li>Rarely demonstrates the expected competency</li></ul>', 'R', 0, 0, true, 'L', true);
$pdf->Ln();

$pdf->writeHTMLCell(73, 4, '', $pdf->SetX(120), '<ul><li>Rarely participates in class activities and/or initiates independent work</li></ul>', 'RB', 0, 0, true, 'L', true);
$pdf->Ln();

$pdf->SetX(103);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(20, 9.5, 'Developing (D)', 1, 'C', 0, 0, '', '', true, 0, false, true, 9.5, 'M');
$pdf->SetFont('helvetica', 'R', 6);
$pdf->writeHTMLCell(73, 4, '', $pdf->SetX(120), '<ul><li>Sometimes demonstrates the competency but needs help in performing authentic tasks</li></ul>', 'TR', 0, 0, true, 'L', true);
$pdf->Ln();

$pdf->writeHTMLCell(73, 4, '', $pdf->SetX(120), '<ul><li>Sometimes participates, minimal supervision</li></ul>', 'RB', 0, 0, true, 'R', true);
$pdf->Ln();

$pdf->SetX(103);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(20, 9.5, 'Approaching Proficiency (AP)', 1, 'C', 0, 0, '', '', true, 0, false, true, 9.5, 'M');
$pdf->SetFont('helvetica', 'R', 6);
$pdf->writeHTMLCell(73, 9.7, '', $pdf->SetX(120), '<ul><li>Developed fundamental knowledge & skills & can transfer understandings with little guidance to authentic tasks</li></ul>', 'TRB', 0, 0, true, 'L', true);
$pdf->Ln();

$pdf->SetX(103);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(20, 7.9, 'Proficient (P)', 1, 'C', 0, 0, '', '', true, 0, false, true, 9.5, 'M');
$pdf->SetFont('helvetica', 'R', 6);
$pdf->writeHTMLCell(73, 4, '', $pdf->SetX(120), '<ul><li>Always demonstrate the expected competency</li></ul>', 'TR', 0, 0, true, 'L', true);
$pdf->Ln();

$pdf->writeHTMLCell(73, 4, '', $pdf->SetX(120), '<ul><li>Always participates in the different activities, works independently</li></ul>', 'RB', 0, 0, true, 'R', true);
$pdf->Ln();

$pdf->SetX(103);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(20,7, 'Advanced (A)', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'R', 6);
$pdf->writeHTMLCell(73, 7, '', $pdf->SetX(120), '<ul><li>Exceeds core requirements (Knowledge, skills, understandings) and automatically transfers them through authentic performance tasks.</li></ul>', 'TRB', 0, 0, true, 'M', true);
$pdf->Ln();

//---------------------------------------- end of center page ----------------------------------------------------------------------------------------------------------------------------------------//

$pdf->SetXY(203, 5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(58, 7, 'Mathematics', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q1', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q2', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q3', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(8, 7, 'Q4', 1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 5);
$pdf->SetFont('helvetica', 'R', 6);
foreach ($subj_details as $sd):
    $first = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 1, $sy);
    $second = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 2, $sy);
    $third = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 3, $sy);
    $fourth = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 4, $sy);

    $pdf->SetX(203);
    $height = GetMultiCellHeight($width, $sd->details, $pdf);
    $pdf->MultiCell($width, 1.5 * $height, $sd->details, 1, 'L', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $first->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $second->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $third->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $fourth->rate, 1, 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->Ln();
endforeach;

$pdf->SetX(203);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(58, 8, 'Understanding the physical and Natural Environment', 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(8, 8, 'Q1', 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(8, 8, 'Q2', 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(8, 8, 'Q3', 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(8, 8, 'Q4', 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 6);
$pdf->SetFont('helvetica', 'R', 6);
foreach ($subj_details as $sd):
    $first = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 1, $sy);
    $second = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 2, $sy);
    $third = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 3, $sy);
    $fourth = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 4, $sy);

    $pdf->SetX(203);
    $height = GetMultiCellHeight($width, $sd->details, $pdf);
    $pdf->MultiCell($width, 1.5 * $height, $sd->details, 'LBR', 'L', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $first->rate, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $second->rate, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $third->rate, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->MultiCell(8, 1.5 * $height, $fourth->rate, 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 1.5 * $height, 'M');
    $pdf->Ln();
endforeach;