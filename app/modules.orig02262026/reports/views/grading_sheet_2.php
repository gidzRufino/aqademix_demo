<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $settings = Modules::run('main/getSet');
                $adviser = Modules::run('academic/getAdvisory', '', segment_3);
                
                $subject = Modules::run('academic/getSpecificSubjects', segment_4);
                $nextYear = $settings->school_year + 1;
                
                $this->SetTitle('Grading Sheet in '.$subject->subject);
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
		$this->Image($image_file, 190, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 10, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(12);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0,4.3,"Grading Sheet in ".$subject->subject,0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"SY  ".$settings->school_year.' - '.$nextYear,0,0,'C');
                $this->Ln(10);
                $this->Cell(0,4.3,$section->level.' - '.$section->section,0,0,'L');
                $this->Cell(0,4.3,'Adviser: '.$adviser->row()->firstname.' '.$adviser->row()->lastname,0,0,'R');
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

$pdf->SetY(45);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, '1ST',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, '2ND',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, '3RD',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, '4TH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$section = Modules::run('registrar/getSectionById', segment_3);
$settings = Modules::run('main/getSet');
$pdf->SetFont('helvetica', 'B', 7);

$subject = Modules::run('academic/getSpecificSubjects', segment_4);
//$student =  Modules::run('registrar/getAllStudentsForExternal', segment_3);
$x = 0;
$z = 0;
foreach($male->result() as $s){
    $z++;
    $x++;
    $pdf->MultiCell(8, 3, $x,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($s->lastname.', '.$s->firstname.' '.$s->middlename),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $assessment = Modules::run('gradingsystem/getPartialAssessment', $s->st_id, $section->section_id, $subject->subject_id, $settings->school_year);
    $firstM = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 1, $settings->school_year); 
    $secondM = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 2, $settings->school_year); 
    $thirdM = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 3, $settings->school_year); 
    $fourthM = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 4, $settings->school_year); 
    
   
    $generalAverage = ($firstM->row()->final_rating+$secondM->row()->final_rating+$thirdM->row()->final_rating+$fourthM->row()->final_rating)/4;
    if($fourthM->row()->final_rating!=''):
        $GA = round($generalAverage, 3);
    else:
        $GA = '';
    endif;
    $pdf->MultiCell(15, 3, ($firstM->row()->final_rating!=""?$firstM->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, ($secondM->row()->final_rating!=""?$secondM->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, ($thirdM->row()->final_rating!=""?$thirdM->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, ($fourthM->row()->final_rating!=""?$fourthM->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, $GA,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    if($generalAverage > 75):
        $pdf->MultiCell(50, 3, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    else:
        $pdf->MultiCell(50, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endif;
    $pdf->ln();
    
    if($z==34):
        $pdf->AddPage();
        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '1ST',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '2ND',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '3RD',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '4TH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
    endif;

    
}
// Blank
for($x=1;$x<=1;$x++){
    $z++;
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
        
    if($z==34):
        $pdf->AddPage();
        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '1ST',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '2ND',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '3RD',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '4TH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
    endif;
}

//end of Blank

$y=0;
foreach($female->result() as $s){
    $z++;
    $y++;
    $pdf->MultiCell(8, 3, $y,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($s->lastname.', '.$s->firstname.' '.$s->middlename),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $assessment = Modules::run('gradingsystem/getPartialAssessment', $s->st_id, $section->section_id, $subject->subject_id, $settings->school_year);
    $firstF = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 1, $settings->school_year); 
    $secondF = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 2, $settings->school_year); 
    $thirdF = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 3, $settings->school_year); 
    $fourthF = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $subject->subject_id, 4, $settings->school_year); 
   
   
    $generalAverage = ($firstF->row()->final_rating+$secondF->row()->final_rating+$thirdF->row()->final_rating+$fourthF->row()->final_rating)/4;
    if($fourthF->row()->final_rating!=''):
        $GA = round($generalAverage, 3);
    else:
        $GA = '';
    endif;
    $pdf->MultiCell(15, 3, ($firstF->row()->final_rating!=""?$firstF->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, ($secondF->row()->final_rating!=""?$secondF->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, ($thirdF->row()->final_rating!=""?$thirdF->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, ($fourthF->row()->final_rating!=""?$fourthF->row()->final_rating:""),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, $GA,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    if($generalAverage > 75):
        $pdf->MultiCell(50, 3, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    else:
        $pdf->MultiCell(50, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endif;
    $pdf->ln();
    
    if($z==34):
        $pdf->AddPage();
        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '1ST',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '2ND',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '3RD',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '4TH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
    endif;
}


$pdf->SetFont('helvetica', 'B', 8);
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$subject_teacher = Modules::run('academic/getSubjectTeacher', $subject_id, segment_3);

$pdf->ln(30);
$pdf->MultiCell(75, 10,  strtoupper($principal->firstname.' '.$principal->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(40, 10,  '','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  strtoupper($subject_teacher->firstname.' '.$subject_teacher->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 10,  'School Principal','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->MultiCell(40, 10,  '','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  'Subject Teacher','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('grading_sheet.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
