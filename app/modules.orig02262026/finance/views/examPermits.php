<?php

$semester = Modules::run('main/getSemester');
if($sem==NULL):
    $sem = $semester;
endif;

switch ($term):
    case 1:
        $grading = '1st Grading';
    break;    
    case 2:
        $grading = 'Second Grading';
    break;    
    case 3:
        $grading = 'Third Grading';
    break;    
    case 4:
        $grading = 'Fourth Grading';
    break;    
endswitch;


//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('registrar/getSingleStudent', $st_id, $this->session->userdata('school_year'));

$next = $settings->school_year + 1;
if($student->grade_level_id > 11 && $student->grade_level_id < 14):
    $strand = Modules::run('subjectmanagement/getStrandCode', $student->strnd_id);
    $loadedSubject = Modules::run('subjectmanagement/getAllSHSubjects', $student->grade_id, $sem, $student->strnd_id);
    $yearSection = strtoupper($student->level.' - '.$strand->short_code.' - '.$student->section);
    $grading = $firstHalf;
    $school_year = ($sem==1?'1st Semester ':'2nd Semester ').$settings->school_year.' - '.$next;
else:
    $loadedSubject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
    $yearSection = strtoupper($student->level.' - '.$student->section);
    $school_year = $settings->school_year.' - '.$next;
endif;



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
$pdf->MultiCell(108, 0, $grading.' Exam Permit',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(108, 0,'( '.$school_year.' )',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(10);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(108, 0,'Name: '. strtoupper($student->firstname.' '.($student->middlename!=""?substr($student->middlename).'. ':""). $student->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(108, 0,'Grade Level / Section: '.$yearSection ,0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(10);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(45, 0, 'Subjects',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, 'Teacher',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(6);
$x=0;
foreach ($loadedSubject as $sl):
    $x++;
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->MultiCell(5, 0, $x,0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(45, 0, $sl->subject,0, 'L', 0, 0, '', '', false, 0, false, true, 10, 'T');
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



