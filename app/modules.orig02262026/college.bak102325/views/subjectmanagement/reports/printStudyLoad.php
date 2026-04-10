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
$data['x'] = 0;
$data['school_year'] = $school_year;
$this->load->view('printStudyLoadDetails', $data);


$pdf->SetAlpha(0.3);
$image_file = K_PATH_IMAGES.'/pilgrim.jpg';
$pdf->Image($image_file, 55, 20, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);


//Close and output PDF document
$pdf->Output('studyLoad.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
