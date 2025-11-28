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

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(130,108);
$pdf->AddPage('P', $resolution);
switch ($term):
    case 1:
        $data['firstHalf'] = 'Prelim';
        
    break;    
    case 2:
        $data['firstHalf'] = 'Midterm';
        
    break;    
    case 3:
        $data['firstHalf'] = 'Semi-Final';
        
    break;    
    case 4:
        $data['firstHalf'] = 'Final';
        
    break;    
    
endswitch;
    $data['pdf'] = $pdf;
    $data['y'] = 3;
$this->load->view('examPermits', $data);

//Close and output PDF document


$pdf->Output('examPermit.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

