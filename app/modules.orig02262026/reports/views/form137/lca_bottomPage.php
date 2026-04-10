<?php 

$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$registrar = Modules::run('hr/getEmployeeByPosition', 'Asst. to the Principal');
$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0,1).'. '.$principal->lastname);
$rname = strtoupper($registrar->firstname.' '.substr($registrar->middlename, 0,1).'. '.$registrar->lastname);

$currentLevel = Modules::run('reports/getCurrentSPR_level', base64_decode(segment_3), '');
$nextLevel = $currentLevel->row()->grade_level_id + 1; 

$admittedTo = Modules::run('registrar/getGradeLevelById', $nextLevel);

$pdf->Ln(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(200, 5, 'Eligible for transfer and admission to',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(6);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(150, 5, 'CERTIFICATE TO TRANSFER / ADMISSION','T', 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(6);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(200, 5, 'TO WHOM IN MAY CONCERN:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(180, 15, "    This is to certify that this is a true and correct Secondary Permanent Record of $studentName. He is eligible for transfer and admission to $admittedTo->level and has no money or property responsibility in this school. ",0, 'L', 0, 0, '', '', true, 0, false, true, 15, '');


$pdf->Ln(12);
$pdf->SetFont('helvetica', 'B',8);
$pdf->MultiCell(50, 5, 'Certified True and Correct:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(80, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(80, 5, 'Attested By:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(10);
$pdf->MultiCell(50, 5, $rname,0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(80, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, "$name",0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln();
$pdf->SetFont('helvetica', 'N',8);
$pdf->MultiCell(50, 5, 'REGISTRAR','T', 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(80, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, "PRINCIPAL / HEAD TEACHER",'T', 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N',6);
$pdf->MultiCell(50, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(80, 5, 'not Valid without SCHOOL SEAL',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');