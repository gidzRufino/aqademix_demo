<?php
class MYPDF extends Pdf {
	//Page header
        
	public function Header() {
                $settings = Modules::run('main/getSet');
                
                if($this->page==1):
                    $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                    $this->Image($image_file, 55, 5, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                    $image_file = K_PATH_IMAGES.'/uccp.jpg';
                    $this->Image($image_file, 145, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                    $this->SetX(10);
                    $this->Ln(5);
                    $this->SetFont('helvetica', 'B', 12);
                    $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                    $this->Ln();
                    $this->SetFont('helvetica', 'N', 9);
                    $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                    $this->Ln();
                    $this->SetFont('helvetica', 'n', 8);
                    $this->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
//                    $this->SetFont('helvetica', 'N', 9);
//                    $this->Cell(0,4.3,'[ '.(segment_8 == 2?'MID TERM':'FINAL TERM').' ]',0,0,'C');
                endif;
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

switch ($sem):
    case 1:
        $semester = 'First';
    break;    
    case 2:
        $semester = 'Second';
    break;    
    case 3:
        $semester = 'Summer';
    break;    
    default :
        $semester = 'First';
    break;    
endswitch;
 
$faculty = Modules::run('hr/getEmployeeName', $faculty_id);
$next = $students->row()->school_year +1;
$scheds = Modules::run('college/schedule/getSchedulePerSection', $section_id, $sem, $school_year); 
$sched = json_decode($scheds);

$subject = Modules::run('college/subjectmanagement/getSubjectPerId', segment_6, $school_year);
$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 9);
// set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);
     
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0,4.3,"COLLEGE GRADE SHEET",0,0,'C');
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'N', 9);
    $pdf->Cell(0,4.3,'[ '.strtoupper($subject->sub_code.' - '.$subject->s_desc_title).' ]',0,0,'C');
    $pdf->Ln(8);
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'Instructor :',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 3, strtoupper($faculty->firstname.' '.$faculty->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'School Year :',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 3, $students->row()->school_year.' - '.$next,0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'Schedule :',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 3, ($sched->count > 0 ? ' [ '.$sched->day.' ] '.$sched->time:'TBA'),0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'Semester :',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 3, $semester,0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln(15);
    
    
    $pdf->MultiCell(8, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(35, 3, 'LAST NAME',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(35, 3, 'FIRST NAME',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 3, 'COURSE',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 3, 'MID TERM',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'N', 9);
    $i = 0;   
    $cnt = 0;
    
    $numOfStudents = count($students->result());
    
    foreach ($students->result() as $s):
        if($s->st_id!=""):
            $i++;
            $cnt++;
            $midGrade = Modules::run('college/gradingsystem/getFinalGrade', $s->st_id, $s->c_id, $subject_id, $sem, $school_year, 2);
            $finGrade = Modules::run('college/gradingsystem/getFinalGrade', $s->st_id, $s->c_id, $subject_id, $sem, $school_year, 4);
            
            if($midGrade):
                switch (TRUE):
                    case $midGrade->gsa_grade <= 5:
                        $mgrade = ($midGrade->gsa_grade!=0?number_format($midGrade->gsa_grade,1):'');
                    break;    
                    case $midGrade->gsa_grade == 6:
                        $mgrade = 'INC';
                    break;    
                    case $midGrade->gsa_grade == 8:
                        $mgrade = 'DRP';
                    break;    
                endswitch;
            endif;
            
            if($finGrade):
                switch (TRUE):
                    case $finGrade->gsa_grade <= 5:
                        $fgrade = ($finGrade->gsa_grade!=0?number_format($finGrade->gsa_grade,1):'');
                        if($finGrade->gsa_grade==5):
                            $remarks = 'FAILED';
                        elseif($finGrade->gsa_grade < 5):
                            $remarks = 'PASSED';
                        endif;
                    break;    
                    case $finGrade->gsa_grade == 6:
                        $fgrade = 'INC';
                        $remarks = '';
                    break;    
                    case $finGrade->gsa_grade == 8:
                        $fgrade = 'DRP';
                        $remarks = 'FAILED';
                    break;    
                endswitch;
            else:
                $remarks = '';
            endif;
            
            $pdf->MultiCell(8, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 3, $i,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(35, 3, strtoupper($s->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(35, 3, ucwords(strtolower($s->firstname)),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 3, strtoupper($s->short_code) .' - '.$s->year_level,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 3, ($midGrade? $mgrade:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 3, ($finGrade? $fgrade:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 3, $remarks,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            
            if($cnt==40):
                $cnt = 0;
                $pdf->AddPage();
                $pdf->SetY(10);
                
                $pdf->MultiCell(8, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(45, 3, 'LAST NAME',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(45, 3, 'FIRST NAME',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(45, 3, 'COURSE',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 3, 'GRADE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln();
                
            endif;
        endif;
    endforeach;    

    
$pdf->Ln(30);
$pdf->MultiCell(75, 10,  strtoupper($principal->firstname.' '.$principal->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(40, 10,  '','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  strtoupper($subject_teacher->firstname.' '.$subject_teacher->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 10,  'Instructor','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->MultiCell(40, 10,  '','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  'Dean','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
    
    
//$html = Modules::run('college/gradingsystem/printGradeSheetRaw', $faculty_id, $section_id, $subject_id, $sem, $term);
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('grading_sheet.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
