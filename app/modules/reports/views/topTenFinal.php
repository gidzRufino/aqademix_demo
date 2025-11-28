<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $settings = Modules::run('main/getSet');
                $nextYear = segment_6 + 1;
                
                $this->SetTitle('Top Ten');
                $this->SetTopMargin(3);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
		$this->Image($image_file, 10, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                
                $this->Ln(12);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0,4.3,$section->level.' FINAL LIST OF HONORS',0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"SY  ".segment_6.' - '.$nextYear,0,0,'C');
                $this->Ln(10);
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

$pdf->SetY(35);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding


$section = Modules::run('registrar/getSectionById', segment_3);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);    
//$subject = explode(',', $subject_ids->subject_id);

$pdf->SetX(15);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(20, 10, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(80, 10, 'Full Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(30, 10,'General Average',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 10, 'RANK',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$x=0;
foreach($topTen->result() as $tt):
    $x++;
    switch ($x):
        case 1:
           $rank = 'First Honors';
        break;    
        case 2:
           $rank = 'Second Honors';
        break;    
        case 3:
           $rank = 'Third Honors';
        break;    
        default :
           $rank = 'With Honors';
        break;    
    endswitch;
    $pdf->SetX(15);
    $pdf->MultiCell(20, 10, $x,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(80, 10, strtoupper($tt->lastname.', '.$tt->firstname.' '.substr($tt->middlename, 0, 1).'.'),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 10, number_format(round($tt->final_rating, 3), 3),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 10, $rank,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
endforeach;

$adviser = Modules::run('academic/getAdvisory', NULL, $sy, segment_3);
$pdf->Ln(10);
$pdf->MultiCell(100, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(30, 10,  'Prepared By:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->MultiCell(120, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  strtoupper($adviser->row()->firstname.' '.$adviser->row()->lastname),0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->MultiCell(120, 5,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(75, 5,  'Adviser',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');


$pdf->SetFont('helvetica', 'B', 10);
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal');
$pdf->Ln(15);
$pdf->MultiCell(30, 10,  'Noted By:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->MultiCell(20, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  strtoupper($principal->firstname.' '.$principal->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  'Principal','', 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');

//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
ob_end_clean();
$pdf->Output('topTen.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
    
