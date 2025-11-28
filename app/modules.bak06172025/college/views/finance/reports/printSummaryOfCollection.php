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
                $this->SetTitle('Business Office Summary of Collection');
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

$from = segment_4;
$to = segment_5;

$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Business Office Summary of Collection', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
// set cell padding

$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(90, 5, 'Official Receipt',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Item Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$z=0;
$total = 0;
$overAll = 0;
$ORCollection = Modules::run('college/finance/getCollectionReport',$from, $to, 0);
foreach($ORCollection->result() as $c): 
    $overAll += $c->amount;
    $z++;
    
    if($overAll!=0):
        $pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, $z,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, $c->item_description,1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($c->amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->ln();
         if($z==34):
             $z=0;
            $pdf->AddPage();
            $pdf->SetY(25);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'Item Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
        endif;   
    endif;
endforeach;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(1, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($overAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
   
        
$pdf->SetXY(80, 47);

$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(90, 5, 'Acknowlegement Receipts',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->SetX(80);
$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Item Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$az=0;
$ARoverAll = 0;
$ARCollection = Modules::run('college/finance/getCollectionReport',$from, $to, 1);
foreach($ARCollection->result() as $ar): 
    
$pdf->SetX(80);
    $ARoverAll += $ar->amount;
    $az++;
    
    if($overAll!=0):
        $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, $az,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, $ar->item_description,1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($ar->amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->ln();
         if($z==34):
             $z=0;
            $pdf->AddPage();
            $pdf->SetY(25);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'Item Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
        endif;   
    endif;
endforeach;

    
    $pdf->SetX(80);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, number_format($ARoverAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln(15);
    
$pdf->SetX(80);  
$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(90, 5, 'Temporary Receipts',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->SetX(80);
$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Item Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$tz=0;
$TPoverAll = 0;
$TPCollection = Modules::run('college/finance/getCollectionReport',$from, $to, 2);
foreach($TPCollection->result() as $tp): 
    
$pdf->SetX(80);
    $TPoverAll += $tp->amount;
    $tz++;
    
    if($overAll!=0):
        $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, $tz,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, $tp->item_description,1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($tp->amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->ln();
         if($z==34):
             $z=0;
            $pdf->AddPage();
            $pdf->SetY(25);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'Item Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
        endif;   
    endif;
endforeach;

    
    $pdf->SetX(80);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, number_format($TPoverAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->Ln(20);
    
$pdf->SetX(80);  
$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(90, 5, 'Cash Breakdown',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 7);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->SetX(80);
$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Denomination',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, 'No. of Counts',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$totalCB = 0;
foreach ($cashbreakdown as $cb):
    $pdf->SetX(80);
    $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, number_format($cb->denomination),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, $cb->fdcb_total_count,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, number_format($cb->denomination*$cb->fdcb_total_count, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->ln();
    
    $totalCB+=($cb->denomination*$cb->fdcb_total_count);
endforeach;
    $pdf->SetX(80);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, number_format($totalCB, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');


$pdf->Ln(30);


$pdf->SetFont('helvetica', 'B', 10);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(138, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Cashier','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
