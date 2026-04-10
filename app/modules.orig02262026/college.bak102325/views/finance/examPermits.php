<?php

$semester = Modules::run('main/getSemester');
if($sem==NULL):
    $sem = $semester;
endif;

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('college/getSingleStudent', $st_id, $this->session->userdata('school_year'), $sem);
$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id);
$next = $settings->school_year + 1;

switch ($student->year_level):
    case 1:
        $year_level = '1st';
    break;
    case 2:
        $year_level = '2nd';
    break;
    case 3: 
        $year_level = '3rd';
    break;
    case 4:
        $year_level = '4th';
    break;
    case 5:
        $year_level = '5th';
    break;    
endswitch;

switch($student->semester):
    case 1:
        $sem = '1ST';
    break;
    case 2:
        $sem = '2ND';
    break;
    case 3:
        $sem = 'SUMMER';
    break;
endswitch;

//

$pdf->SetXY(0,$y);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(108, 0, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(108, 0, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(6);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(108, 0, $firstHalf.' Exam Permit',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(108, 0,'( '.$sem.' SEMESTER '.$settings->school_year.' - '.$next.' )',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(10);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(108, 0,'Name: '. strtoupper($student->firstname.' '.($student->middlename!=""?substr($student->middlename).'. ':""). $student->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(108, 0,'Course / Year: '. strtoupper($student->short_code.' '.$year_level.' YR'),0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(10);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(45, 0, 'Subjects',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, 'Instructor',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(6);
$x=0;
foreach ($loadedSubject as $sl):
    $x++;
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->MultiCell(5, 0, $x,0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(45, 0, $sl->sub_code,0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(45, 0, '','B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln();
endforeach;

$cashier = Modules::run('hr/getEmployeeByPosition', 'Cashier');
$pdf->Ln(10);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(45, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, strtoupper($this->session->name),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(45, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, 'Cashier','T', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 20, $y+25, 75, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);



