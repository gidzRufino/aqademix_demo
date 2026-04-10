<?php
set_time_limit(120);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $this->SetY(2);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 11);
                $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                $this->Image($image_file, 60, 5, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $image_file = K_PATH_IMAGES.'/uccp.jpg';
                $this->Image($image_file, 140, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->SetX(10);
                $this->Ln(5);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
                $this->SetFont('helvetica', 'N', 9);
                $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln();
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

$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'CASH COLLECTION REPORT', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, date('F d, Y', strtotime($from)), 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
// set cell padding
$pdf->SetFont('helvetica', 'B', 14);

$collection = Modules::run('finance/getCollectionReport', $from, $to); 
$chequePayments = Modules::run('college/finance/getChequePayments', $from);
foreach ($chequePayments as $cp):
    $totalC += $cp->t_amount;
endforeach;
$overAll = 0;
foreach($collection->result() as $c): 
    $overAll += $c->amount;
endforeach; 

$pdf->Cell(0,0, 'Total Collection : '.number_format($overAll+$totalC,2,'.',','), 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
$pdf->SetFont('helvetica', 'B', 10);

$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Denomination',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Total',1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->ln();

foreach ($cashbreakdown as $cb):
    $pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, number_format($cb->denomination),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, $cb->fdcb_total_count,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, number_format($cb->denomination*$cb->fdcb_total_count, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->ln();
    $totalCash += ($cb->denomination*$cb->fdcb_total_count);
endforeach;



$pdf->SetFont('helvetica', 'B', 10);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(40, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(80, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, number_format($totalCash, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(25);
$pdf->SetX(25);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(50, 5, 'Cheque Payments',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        
        
        $cpCount = 0;
        
        foreach ($chequePayments as $cp):
            $cpCount++;
            $totalChequePayments += $cp->t_amount;
            $pdf->SetX(20);
            $pdf->SetFont('helvetica', 'N', 9);
            $pdf->MultiCell(35, 5, ''.$cp,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(35, 5, $cp->bank_short_name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, $cp->tr_cheque_num,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, number_format(($cp->t_amount), 2, ".", ','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endforeach;
        
        
            $pdf->SetX(25);
            $pdf->SetFont('helvetica', 'N', 9);
            $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln(5);
            
            $pdf->SetX(25);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, number_format(($totalChequePayments), 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln(10);

$pdf->Ln(30);
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


//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
