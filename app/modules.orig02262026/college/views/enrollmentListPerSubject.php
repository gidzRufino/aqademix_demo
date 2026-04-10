<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                
                
                //$this->SetTitle('Grading Sheet in '.$subject->subject);
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
                
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
		$this->Image($image_file, 60, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $image_file = K_PATH_IMAGES.'/uccp.jpg';
                $this->Image($image_file, 140, 8, 12, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(18);
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0,4.3,"List of Enrollees",0,0,'C');
                $this->Ln(15);
                
                
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

//variables
$subject = Modules::run('college/subjectmanagement/getSubjectPerId',segment_4, segment_7);
$section = Modules::run('college/subjectmanagement/getSectionById', segment_5, segment_7);
$scheds = Modules::run('college/schedule/getSchedulePerSection', segment_5,segment_6,segment_7); 
$sched = json_decode($scheds);
$instructor = Modules::run('collegel/schedule/getInstructorPerSchedule', $sched->sched_code);
$next = segment_7 + 1;

switch(segment_6):
    case 1:
        $sem = '1st Semester';
    break;
    case 2:
        $sem = '2nd Semester';
    break;
    case 3:
        $sem = 'Summer';
    break;
endswitch;



$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(280,216);
$pdf->AddPage('P', $resolution);

$pdf->SetY(35);


$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 5, 'Subject:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(50, 5, $subject->sub_code,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(30, 5,'Description:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(70, 5, $subject->s_desc_title,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 5, 'Time:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(50, 5, ($sched->count > 0 ? $sched->time:'TBA'),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(30, 5, 'Day:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(70, 5, ($sched->count > 0 ? $sched->day:'TBA'),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 5, 'Instructor:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(50, 5, strtoupper($sched->instructor),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(30, 5, 'Section:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(70, 5, $section->section,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 5, 'SY:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(50, 5, segment_7.' - '.$next,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(30, 5, 'Semester:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(70, 5, $sem,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(20);
$pdf->SetFont('helvetica', 'B', 10);
// set cell padding
$pdf->SetX(8);
$pdf->MultiCell(10, 5, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, 'Course',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, 'Year',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$x = 0;
$xy = 0;        
foreach ($students as $st):

    if ($st->status == 1):
        switch ($st->year_level):
            case 1:
                $year_level = 'First Year';
                break;
            case 2:
                $year_level = 'Second Year';
                break;
            case 3:
                $year_level = 'Third Year';
                break;
            case 4:
                $year_level = 'Fourth Year';
                break;
            case 5:
                $year_level = 'Fifth Year';
                break;
        endswitch;
        $x++;
        $xy++;

        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->SetX(8);
        $pdf->MultiCell(10, 5, $xy, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, strtoupper($st->lastname), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, ucwords(strtolower($st->firstname)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(45, 5, strtoupper($st->short_code), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, $year_level, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        if ($x == 30):
            $x = 0;
            $pdf->AddPage('P', $resolution);

            $pdf->SetY(35);
            $pdf->SetFont('helvetica', 'B', 10);
            // set cell padding
            $pdf->SetX(8);
            $pdf->MultiCell(10, 5, '#', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, 'Last Name', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, 'First Name', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, 'Course', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 5, 'Year', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endif;
    endif;
endforeach;



//Close and output PDF document
$pdf->Output('Enrollees.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
