<?php 
$pdf->Ln(8);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(200, 5, 'STANDARD INTELLIGENCE TEST TAKEN',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');

    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->MultiCell(80, 5, 'NAME AND FORM OF TEST',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, 'Date Taken',1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
    $pdf->MultiCell(45, 5, 'Score Received',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(45, 5, 'Percentile Rank',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    
for($i=0;$i<=5;$i++):
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->MultiCell(80, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
    $pdf->MultiCell(45, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(45, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');

endfor;

$pdf->Ln(8);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(200, 5, 'SUMMARY OF CREDITS ACHIEVED TOWARD GRADUATION',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(50, 5, '1st YEAR CURRICULUM',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '2nd YEAR CURRICULUM',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '3rd YEAR CURRICULUM',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '4th YEAR CURRICULUM',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
for($i=1;$i<=4; $i++):
    $pdf->MultiCell(30, 5, 'Subjects',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, 'YR.',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, 'C.E.',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
endfor;


for($i=1; $i<=12; $i++):
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Ln();
    $pdf->MultiCell(30, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
endfor;

$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln();
$pdf->setCellPaddings(0,0,0,0);
$pdf->MultiCell(120, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'LEGEND:',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 4, 'YR.',0, 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(30, 4, 'YEAR COMPLETED',0, 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$pdf->MultiCell(120, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 4, 'C.E. ',0, 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(30, 4, 'CREDITS EARNED',0, 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');

$pdf->setCellPaddings(1,1,1,1);
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(200, 5, 'REMARKS on the student\'s character and habits',1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(20, 5, '1st Year',1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(180, 5, '','TRB', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(20, 5, '2nd Year',1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(180, 5, '','TRB', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(20, 5, '3rd Year',1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(180, 5, '','TRB', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(20, 5, '4th Year',1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(180, 5, '','TRB', 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname.' '.$principal->lastname);

$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B',8);
$pdf->MultiCell(130, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, "$name",0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N',8);
$pdf->MultiCell(130, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, "PRINCIPAL / HEAD TEACHER",'T', 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(200, 5, 'CERTIFICATE TO TRANSFER',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(6);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(49.9, 5, 'I CERTIFY that this is a true record of',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(95, 5, "$studentName",'B', 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(20, 5, 'as of this',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(30, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(10, 5, 'day of',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(40, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(40, 5, '.  He / She is eligible for',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$currentLevel = Modules::run('reports/getCurrentSPR_level', base64_decode(segment_3));
if($currentLevel->row()->grade_level_id==18):
  $nextLevel = $currentLevel->row()->grade_level_id - 3;  
else:
  $nextLevel = $currentLevel->row()->grade_level_id + 1;  
endif;

$admittedTo = Modules::run('registrar/getGradeLevelById', $nextLevel);

$pdf->Ln();
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(20, 5, 'admission to',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(30, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(120, 5, ' as (regular, irregular) student, and he/she has no property',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln();
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(120, 5, 'accountability in this school.',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B',8);
$pdf->MultiCell(130, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, "$name",0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N',8);
$pdf->MultiCell(130, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, "PRINCIPAL / HEAD TEACHER",'T', 'C', 0, 0, '', '', true, 0, false, true, 5, '');