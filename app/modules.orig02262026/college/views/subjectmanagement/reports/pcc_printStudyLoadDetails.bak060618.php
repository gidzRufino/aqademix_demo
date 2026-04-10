<?php
$semester = Modules::run('main/getSemester');

if($sem==NULL):
    $sem = $semester;
endif;

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('college/getSingleStudent', $st_id, $this->session->userdata('school_year'), $sem);
$next = $this->session->userdata('school_year') + 1;

$pdf->SetXY(5,5+$x);
$pdf->SetFont('times', 'B', 10);
$pdf->MultiCell(170, 10, $copyOf, '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 10, ' ', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', 'B', 10);
$pdf->MultiCell(25, 5, $student->uid, '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, ucfirst($student->lastname), '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(45, 5, ucfirst($student->firstname), '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(3, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, substr($student->middlename, 0,1), '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, substr($student->sex, 0,1), '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(25, 5, 'ID Number', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Last Name', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(45, 5, 'First Name', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(3, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'M.I.', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Gender', '', 'C', 0, 0, '', '', true);
$pdf->Ln(10);

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
        $sem = '1st';
    break;
    case 2:
        $sem = '2nd';
    break;
    case 3:
        $sem = 'Summer';
    break;
endswitch;

$pdf->SetFont('times', 'B', 9);
$pdf->MultiCell(25, 5, $student->short_code, '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(20, 5, $year_level, '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(75, 5, $student->college_department, '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, $sem, '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(22, 5, date('F d, Y'), '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(3, 5, '|', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, date('G:i:s'), '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 9);
$pdf->MultiCell(25, 5, 'Course', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(21, 5, 'Year', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(72, 5, 'Department', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(20, 5, 'Semester', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Validate Date | Time', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(185, 5, '', 'T', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 10);
$pdf->MultiCell(20, 5, 'SUB Code', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Subject', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(20, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id);

$totalUnits = 0;
foreach ($loadedSubject as $sl):
    $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
endforeach;

foreach ($loadedSubject as $sl):
	//$pdf->SetX(7);
	$pdf->SetFont('times', '', 8);
	$pdf->MultiCell(20, 5, $sl->sub_code, 1, 'C', 0, 0, '', '', true);
	$pdf->MultiCell(55, 5, $sl->s_desc_title, 1, 'L', 0, 0, '', '', true);
	$pdf->MultiCell(12, 5, $sl->s_lect_unit, 1, 'C', 0, 0, '', '', true);

	$scheds = Modules::run('college/schedule/getSchedulePerSection', $sl->cl_section); 
    $sched = json_decode($scheds);
    $instructor = Modules::run('collegel/schedule/getInstructorPerSchedule', $sched->sched_code);

	$pdf->MultiCell(12, 5, ($sched->count > 0 ? $sched->day:'TBA'), 1, 'C', 0, 0, '', '', true);
	$pdf->MultiCell(20, 5, ($sched->count > 0 ? $sched->time:'TBA'), 1, 'C', 0, 0, '', '', true);
	$pdf->MultiCell(12, 5, ($sched->count > 0 ? $sched->room:'TBA'), 1, 'C', 0, 0, '', '', true);
	$pdf->MultiCell(30, 5, ($instructor->lastname == "" ? "" : $instructor->lastname.', '.$instructor->firstname.' '), 1, 'C', 0, 0, '', '', true);
	$pdf->MultiCell(30, 5, $sl->section, 1, 'C', 0, 0, '', '', true);
	$pdf->Ln();
endforeach;

/*

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'GE 502', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Readings in Philippine History', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'GE 503', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'The Contemporary World', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'GE 504', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Mathematics in the Modern World', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'IT 102', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Computer Programming & Problem Solving 1', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'IC 101', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'PCC Institutional Course', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'VEd 101', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Values education', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'NSTP 1', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'LTS/CWTS/ROTC', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'GE 505', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Living in the IT Era', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(20, 5, 'PE 1', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Fundamentals of Martial Arts', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true);
*/
$pdf->Ln(10);
$pdf->SetFont('times', 'I', 8);
$pdf->MultiCell(60, 5, '“In consideration of my admission to the Philippine Countryville School and of the privileges of the students in this institutions, I hereby abide and comply all the rules and regulations set by administration and the department in which I am enrolled.', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('times', '', 9);
$pdf->MultiCell(29, 5, 'Student’s Signature:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(5, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(24, 5, 'Business Office:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(25);

$pdf->SetFont('times', 'BU', 8);
$pdf->MultiCell(150, 3, 'CEPRIANO N. JUSTO, JR.', 0, 'R', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('times', '', 8);
$pdf->MultiCell(143, 3, 'School Registrar', 0, 'R', 0, 0, '', '', true);
$pdf->Ln(200);


