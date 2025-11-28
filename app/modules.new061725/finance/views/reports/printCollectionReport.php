<?php
set_time_limit(120);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
                $this->SetTitle('Business Office Collections');
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

$from = segment_3;
$to = segment_4;

$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Business Office Collection Report', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
// set cell padding
$pdf->setX(0);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Particulars',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$z=0;
$total = 0;
$overAll = 0;
foreach($collection->result() as $c): 
    $pdf->setX(0);
    $overAll += $c->t_amount;
    $z++;
    
    if($overAll!=0):
        $pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, date('F d, Y', strtotime($c->t_date)),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, $c->ref_number,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, $c->lastname.', '.$c->firstname,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(40, 3, $c->item_description,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($c->t_amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->ln();
         if($z==34):
             $z=0;
            $pdf->AddPage();
            $pdf->SetY(25);
            $pdf->setX(0);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(60, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(40, 3, 'Particulars',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
        endif;   
    endif;
endforeach;
        
        $pdf->setX(0);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(160, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($overAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        
        $pdf->Ln(20);
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(138, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, strtoupper($this->session->basicInfo->firstname." ".substr($this->session->basicInfo->middlename, 1).". ".$this->session->basicInfo->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(138, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'Cashier','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');


//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
