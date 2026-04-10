<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $nextYear = $settings->school_year + 1;
                
                $this->SetTitle(strtoupper($settings->set_school_name));
                $this->SetTopMargin(4);
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

$settings = Modules::run('main/getSet');


$data ['sem'] = $sem;
$data['st_id'] = $st_id;
$data['pdf'] = $pdf;
$data['x'] = 15;
$data['imageY'] = 5;
$data['copyOf'] = 'Registrar\'s Copy';
$this->load->view('pcc_printStudyLoadDetails', $data);

$pdf->Ln(30);
$pdf->SetX(0);
$pdf->MultiCell(216, 0, '','T', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$data['st_id'] = $st_id;
$data['pdf'] = $pdf;
$data['x'] = 175;
$data['imageY'] = 165;
$data['copyOf'] = 'Student\'s Copy';
$this->load->view('pcc_printStudyLoadDetails', $data);

$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 65, 20, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 65, 20+$data['x'], 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

//Close and output PDF document
$pdf->Output('studyLoad.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
