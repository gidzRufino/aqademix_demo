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
$resolution= array(280,216);
$pdf->AddPage('P', $resolution);

$from = segment_3;
$to = segment_4;

$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Business Office Collection AR Report', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(10);
// set cell padding

$pdf->SetFont('helvetica', 'N', 8);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(80, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$z=0;
$total = 0;
$overAll = 0;
foreach($collection->result() as $c): 
    $overAll += $c->amount;
    $z++;
    
    if($overAll!=0):
        if($c->acnt_type==0):
            $pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, date('F d, Y', strtotime($c->t_date)),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, $c->ref_number,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(80, 3, $c->lastname.', '.$c->firstname,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        else:
            $otherAccount = Modules::run('finance/getOtherAccountDetails', $c->t_st_id);
            $pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, date('F d, Y', strtotime($c->t_date)),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, $c->ref_number,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(80, 3, $otherAccount->fo_lastname.', '.$otherAccount->fo_firstname,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
        $pdf->MultiCell(30, 3, number_format($c->amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->ln();
         if($z==25):
             $z=0;
            $pdf->AddPage();
            $pdf->SetY(25);
            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(80, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
        endif;   
    endif;
endforeach;

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(160, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($overAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
         
        $pdf->Ln(15);
        if($z==29):
            $z=0;
            $pdf->AddPage();
            $pdf->SetY(25);
        endif;

        $pdf->MultiCell(50, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, 'Total Collection Per Item',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'N', 8);
        $groupCollection = Modules::run('finance/getTotalGroupCollection', $from, $to, 1);
        
        foreach($groupCollection as $gc): 
            
            $pdf->MultiCell(50, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, $gc->fin_category,1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, number_format($gc->amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
        endforeach;
            
        $pdf->Ln(20);
        
        
        $basicInfo = Modules::run('users/getBasicInfo', $this->session->username);
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, $basicInfo->firstname.' '.$basicInfo->lastname,'', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(55, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'Remitted By','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(55, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, 'Received By','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

        



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
