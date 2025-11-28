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
                
                //$this->SetTitle('Grading Sheet in '.$subject->subject);
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/school_logo.png';
		$this->Image($image_file, 190, 8, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 10, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(8);
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0,4.3,"List of Enrollees",0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"SY  ".$settings->school_year.' - '.$nextYear,0,0,'C');
                $this->Ln();
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

function addMalePage($pdf)
{
    $x=0;
    $pdf->AddPage();
    $pdf->SetY(30);
    $pdf->SetFont('helvetica', 'B', 8);
    // set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$section = Modules::run('registrar/getSectionById', segment_3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('P', $resolution);

$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$x = 0;
foreach($male->result() as $s){
$x++;
$pdf->MultiCell(8, 3, $x,1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, strtoupper($s->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, strtoupper(substr($s->middlename, 0, 1)).'.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, strtoupper($s->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

if($x==32):
    addMalePage($pdf);
endif;
}

$y = 0;
$pdf->SetY(45.5);
foreach($female->result() as $f){
$y++;
$pdf->SetX(110);
$pdf->MultiCell(8, 3, $y,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, strtoupper($f->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, strtoupper(substr($f->middlename, 0, 1)).'.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(36, 3, strtoupper($f->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

if($y==32):
    $y=0;
    $x=0;
    $pdf->AddPage();
    $pdf->SetY(30);
    $pdf->SetFont('helvetica', 'B', 8);
    // set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
endif;

}

$pdf->SetY(290);
$pdf->SetX(75);
$pdf->MultiCell(30, 7.3, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 7.3, $male->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7.3);
$pdf->SetX(75);
$pdf->MultiCell(30, 7.3, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 7.3, $female->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7.3);
$pdf->SetX(75);
$pdf->MultiCell(30, 7.3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 7.3, $male->num_rows()+$female->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


//$student =  Modules::run('registrar/getAllStudentsForExternal', segment_3);

//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output($section->level.' - '.$section->section.'_Enrollees.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
