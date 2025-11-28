<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $nextYear = $settings->school_year + 1;
                
                $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                $this->Image($image_file, 55, 3, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $image_file = K_PATH_IMAGES.'/uccp.jpg';
                $this->Image($image_file, 145, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
                $this->SetFont('helvetica', 'N', 9);
                $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln();
                $this->SetFont('helvetica', 'n', 8);
                $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');

                $this->SetTitle(strtoupper($settings->short_name));
                
                switch(segment_7):
                    case 1:
                        $termInWords = 'PRELIM';
                    break;    
                    case 2:
                        $termInWords = 'MID TERM';
                    break;    
                    case 3:
                        $termInWords = 'SEMI FINAL';
                    break;    
                    case 4:
                        $termInWords = 'FINAL';
                    break;    
                endswitch;

                $this->Ln(8);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0,4.3,"REQUEST FOR $termInWords GRADE",0,0,'C');
                $this->Ln(5);
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('P', $resolution);

$semester = Modules::run('main/getSemester');

if($sem==NULL):
    $sem = $semester;
endif;

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('college/getSingleStudent', $st_id, $sy, $sem);
$next = $sy + 1;

$pdf->SetXY(5,30);
$pdf->SetFont('helvetica', 'B', 9);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

//basic info
$pdf->Ln(8);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(42, 0, $student->uid,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, ucfirst($student->lastname),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, ucfirst($student->firstname),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, substr($student->middlename, 0,1),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, substr($student->sex, 0,1),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(42, 0, 'ID Number',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Last Name',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'First Name',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'M.I.',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Gender',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

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

//basic info
$pdf->Ln();
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(84, 0, strtoupper($student->short_code),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, $year_level,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, $sy.' - '. $next,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, $sem,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(4);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(84, 0, 'Course',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Year',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'School Year',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(42, 0, 'Semester',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(7);
$pdf->SetX(0);
$pdf->MultiCell(216, 0, '','T', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(20, 0, 'Sub Code',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(90, 0, 'Subject',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, 'Unit/s',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Grade',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'Instructor',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
//$pdf->MultiCell(40, 0, 'Remarks',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $student->semester, $student->school_year);



$totalUnits = 0;
foreach ($loadedSubject as $sl):
    $totalUnits += ($sl->sub_code=="NSTP 11" || $sl->sub_code=="NSTP 12" ? 3 :($sl->s_lect_unit+$sl->s_lab_unit));
endforeach;

$units=0;
$deductUnits = 0;
foreach ($loadedSubject as $sl):
    
    $scheds = Modules::run('college/schedule/getSchedulePerSection', $sl->cl_section, $student->semester, $student->school_year); 
    $sched = json_decode($scheds);
    $instructor = Modules::run('college/schedule/getInstructorPerSchedule', $sched->sched_code, $sy);
    
    $grade = json_decode(Modules::run('college/gradingsystem/getTermGrade',$student->uid, NULL, $sl->s_id, $student->semester, $sy, $term));
    
    switch (TRUE):
        case $grade <= 5:
            $fgrade = ($grade!=0?number_format($grade,1):'');
            
        break;    
        case $grade == 6:
            $fgrade = 'INC';
        break;    
        case $grade == 8:
            $fgrade = 'DRP';
        break;    
    endswitch;
    $unit = ($sl->sub_code=="NSTP 11" || $sl->sub_code=="NSTP 12" ? ($fgrade==""?0:3) :($grade>=5||$fgrade==""?0:($sl->s_lect_unit+$sl->s_lab_unit)));
    
   // $remarks = ($grade->finalGrade > 3 ? 'FAILED':($grade->finalGrade >= 1 ? 'PASSED': ($grade->finalGrade==5?'FAILED':($grade->finalGrade >= 5 ? 'DROPPED':'NG' ))));
    $pdf->SetX(15);
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->MultiCell(20, 0, $sl->sub_code,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(90, 0, $sl->s_desc_title,1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(10, 0, $unit,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    
    
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(20, 0, ($grade!=0?$fgrade:''),1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->SetFont('helvetica', 'N', 7);
    $pdf->MultiCell(40, 0, ucwords(strtolower($instructor->lastname.', '.$instructor->firstname)).' ',1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    //$pdf->MultiCell(40, 0, $remarks,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln();
    if($unit == 0):
        $deductUnits += ($sl->sub_code=="NSTP 11" || $sl->sub_code=="NSTP 12" ? 3 :($sl->s_lect_unit+$sl->s_lab_unit));
    endif;
endforeach;
    $pdf->SetX(20);
    $pdf->MultiCell(20, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(85, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(10, 0, $totalUnits-$deductUnits,1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

    
$registrar = Modules::run('hr/getEmployeeByPosition','Registrar');

$pdf->SetFont('helvetica', 'B', 9);
$pdf->Ln(20);
$pdf->SetX(15);
$pdf->MultiCell(130, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 0, strtoupper($registrar->firstname.' '.substr($registrar->middlename, 0,1).'. '.$registrar->lastname),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(130, 0, '',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 0, 'REGISTRAR','T', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetAlpha(0.3);
$image_file = K_PATH_IMAGES.'/pilgrim.jpg';
$pdf->Image($image_file, 58, 20, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
$pdf->Ln();
$pdf->SetXY(7, 150);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(203, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');


$pdf->Output('classCard.pdf', 'I');