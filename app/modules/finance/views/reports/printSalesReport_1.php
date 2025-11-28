<?php
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
                $this->SetTitle('Cafeteria Sales Report');
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
$pdf->Cell(0, 0, 'Cafeteria Sales Report', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
// set cell padding

$pdf->SetFont('helvetica', 'B', 7);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(8, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'TRANSACTION #',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, 'NAME OF ITEM',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, 'PRICE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$z=0;
$total = 0;
$overAll = 0;
foreach($sales as $s): 
    $z=1;
    $total = ($s->item_quantity * $s->item_price);
    $overAll += $total;
    $pdf->MultiCell(8, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, $s->transaction_num,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, $s->transaction_date,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, $s->canteen_item_name,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, number_format($s->item_price, 2, '.',','),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, number_format($total, 2, ".", ','),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
     if($z==34):
        $pdf->AddPage();
        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(40, 3, 'TRANSACTION #',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, 'NAME OF ITEM',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, 'PRICE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
    endif;   
    
$pdf->ln();    

  
endforeach;



//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('canteen_sales_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
